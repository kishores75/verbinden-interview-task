@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <b>Hobbies Form</b>
            <a href="{{ url('/hobbies-show') }}" role="button" class="btn btn-primary" style="float: inline-end">View List</a>
        </div>
        <div class="card-body">
            <form id="hobbiesForm" method="POST" autocomplete="off">
                @csrf
                <h5 class="card-title">Please fill your data's</h5>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="Message" placeholder="Enter name">
                    <small id="Message" class="form-text text-muted"></small>
                    <input type="hidden" class="form-control" id="id" name="id" value="0">
                    <span class="text-danger" id="name-error"></span>
                </div>
                <div class="form-group">
                    <label for="name">Hobbies:</label>
                    <div class="form-check">
                        <input class="form-check-input hChecked" type="checkbox" id="hobbies1" name="hobbies" value="1">
                        <label class="form-check-label" for="Checkbox"> Singing </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input hChecked" type="checkbox" id="hobbies2" name="hobbies" value="2">
                        <label class="form-check-label" for="Checkbox"> Dancing </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input hChecked" type="checkbox" id="hobbies3" name="hobbies" value="3">
                        <label class="form-check-label" for="Checkbox"> Indoor games </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input hChecked" type="checkbox" id="hobbies4" name="hobbies" value="4">
                        <label class="form-check-label" for="Checkbox"> Outdoor games </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input hChecked" type="checkbox" id="hobbies5" name="hobbies" value="5">
                        <label class="form-check-label" for="Checkbox"> Others </label>
                    </div>
                    <span class="text-danger" id="hobbies-error"></span>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div id="form_status"></div>
            <button type="button" class="btn btn-primary" id="refresh" style="float: inline-end">Refresh</button>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            //Refresh Form
			$('#refresh').on('click', function() {
                $("#name-error").html('');
                $("#hobbies-error").html('');
                $("#id").val('0');
                $("#hobbiesForm")[0].reset();
                $("#Message").html('');
            });
			//Welcome Message
            $('#name').on('change', function() {
                var name = $('#name').val();
                $("#Message").html('Welcome to our site <b>' + name + '</b>');
            });
            $('#hobbiesForm').on('change', function() {
                $("#name-error").html('');
                $("#hobbies-error").html('');
                var id = $('#id').val();
                var name = $('#name').val();
				var chks = document.getElementsByName('hobbies');
				var hasChecked = false;
				for (var i = 0; i < chks.length; i++) { if (chks[i].checked) { hasChecked = true; break; } }
				if (name){
                    if(hasChecked == false) {
                        $("#hobbies-error").html('Please select at least one hobbies.');
                        return false;
                    }
                    else{
                        var checkbox = $('.hChecked:checked');
                        if(checkbox.length > 0) { var checkbox_value = []; $(checkbox).each(function(){ checkbox_value.push($(this).val()); }); }
                        var hobbies = checkbox_value.toString();
                        if(id == 0){
                            $.ajax({
                                url:"{{url('hobbies-add')}}",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "name":name,
                                    "hobbies":hobbies
                                },
                                success: function(response)
                                {
                                    if(response){
                                        if(response.success){
                                            $("#form_status").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> <strong>Success! </strong>'+ response.success +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                                            $("#id").val(response.id);
                                            window.setTimeout(function(){ $("#form_status").html(''); },2000);
                                        }else{
                                            $("#form_status").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Failed! </strong>'+ response.failure +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                                        }
                                    }else{
                                        $("#form_status").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Failed! </strong>'+ response.failure +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                                    }
                                }
                            });
                        } else{
                            $.ajax({
                                url:"{{url('hobbies-update')}}",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id":id,
                                    "name":name,
                                    "hobbies":hobbies
                                },
                                success: function(response)
                                {
                                    if(response){
                                        if(response.success){
                                            $("#form_status").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> <strong>Success! </strong>'+ response.success +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                                            window.setTimeout(function(){ $("#form_status").html(''); },2000);
                                        }else{
                                            $("#form_status").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Failed! </strong>'+ response.failure +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                                        }
                                    }else{
                                        $("#form_status").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Failed! </strong>'+ response.failure +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>');
                                    }
                                }
                            });
                        }
                    }
                }else{
                    $("#name-error").html('Please enter name.');
                    return false;
                }
            });
        });
    </script>
@endsection