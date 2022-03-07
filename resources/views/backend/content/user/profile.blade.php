@extends('backend.layout.master')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <form action="{{ route('user-profile.update',auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="">User Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" data-validation="required">
                    </div>
                    <div class="form-group col-md-4">
                    <label for="">User Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" data-validation="required">
                    </div>
                    <div class="form-group col-md-4">
                    <label for="">User Contact:</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" data-validation="number">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="">Password:</label>
                    <input type="password" name="password" class="form-control" data-validation="required">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="">Confirm Password:</label>
                    <input type="password" name="confirmPassword" class="form-control" data-validation="required">
                    <div class="pt-2" id="confirmationMessage">
                        
                    </div>
                    </div>
                    <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success float-right">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
    <script>
        $(document).ready(function () {
            $.validate();
            // password check
            $("input[name='confirmPassword']").keyup(function (e) { 
                var password = $("input[name='password']").val();
                var passwordConfirm = $("input[name='confirmPassword']").val();
                if(password == passwordConfirm){
                    $("#confirmationMessage").html('<span class="text-success">Password matched</span>');
                }else{
                    $("#confirmationMessage").html('<span class="text-danger">Password did not match</span>');
                }
            });
        });
    </script>
@endpush