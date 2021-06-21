<?php

namespace App\Http\Controllers;

use App\Models\Hobbies;
use Illuminate\Http\Request;

class HobbiesController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function show()
    {
        $data['hobbies'] = Hobbies::select('name', 'hobbies')->get();
        return view('data', $data);
    }
    public function store(Request $request)
    {
        //validations of fields
        $this->validate($request, [
            'name' => 'required',
            'hobbies' => 'required'
        ],
        [
            'name.required' => 'Name field is required',
            'hobbies.required' => 'Hobbies field is required'
        ]);

        $id = $request->input('id');
        if($id == 0){
            //storing data into database
            $save = new Hobbies;
            $save->name = $request->input('name');
            $save->hobbies = $request->input('hobbies');
            $save->save();
            $insert_id = $save->id;
            if($insert_id){
                //this if used to check to whether the records are save or not
                return response()->json(['success' => 'Hobbies has been added succesfully', 'id' => $insert_id]);
                //in above return reponse to view with success with message
            }
            else{
                return response()->json(['failure' => 'Something went wrong try again later']);
                //in above return reponse to view with failure with message
            }
        } else{
            $id = $request->input('id');
            $save = Hobbies::findOrFail($id);
            $save->name = $request->input('name');
            $save->hobbies = $request->input('hobbies');
            $save->save();
            if($save){
                //this if used to check to whether the records are save or not
                return response()->json(['success' => 'Hobbies has been added succesfully', 'id' => $id]);
                //in above return reponse to view with success with message
            }
            else{
                return response()->json(['failure' => 'Something went wrong try again later']);
                //in above return reponse to view with failure with message
            }
        }
    }
}
