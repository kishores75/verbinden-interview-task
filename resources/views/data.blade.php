@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <b>Hobbies List</b>
            <a href="{{ url('/') }}" role="button" class="btn btn-primary" style="float: inline-end">Go Back</a>
        </div>
        {{--  1- Singing 2 - Dancing 3 - Indoor games 4 - Outdoor games 5 - Others.  --}}
        @php $idArray = array("Singing", "Dancing", "Indoor games", "Outdoor games", "Others"); @endphp
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Hobbies</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hobbies as $key => $value)
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                                @php $j = 1; $id = explode(",", $value->hobbies); @endphp
                                @for($i=0; $i<count($id); $i++)
                                    {{ $j.". ".$idArray[$id[$i]-1] }} <br> @php $j++; @endphp
                                @endfor
                            </td>
                        </tr>
                    @empty
                        <td></td>
                        <td style="text-align: center">No Data Available.</td>
                        <td></td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection