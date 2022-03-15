@extends('backend.layout.master')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <form action="{{ route('user-profile.update', auth()->user()->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-row">
                    <div class="form-group col-md-12 col-12">
                        <label for="">Select Company</label>
                        <select name="company" class="form-control" data-validation="required">
                            @foreach ($companies as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $user->company) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">User Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                            data-validation="required">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">User Email:</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                            data-validation="required">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">User Contact:</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}"
                            data-validation="number">
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
        <div class="col-md-12 col-12">
            <h4 class="text-center text-info p-3">Company Details</h4>
            <form action="{{ route('company.update', $user->company) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ $current_company->name }}"
                            data-validation="required">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Email:</label>
                        <input type="text" name="email" class="form-control" value="{{ $current_company->email }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Address:</label>
                        <input type="text" name="address" class="form-control" value="{{ $current_company->address }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Phone:</label>
                        <input type="text" name="phone" class="form-control" value="{{ $current_company->phone }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Website:</label>
                        <input type="text" name="website" class="form-control" value="{{ $current_company->website }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Last Entry Date:</label>
                        <input type="text" name="last_entry_date" class="form-control date-picker"
                            value="{{ $current_company->last_entry_date }}" data-validation="date">
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-success pull-right">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
    <script>
        $(document).ready(function() {
            $.validate();
            // password check
            $("input[name='confirmPassword']").keyup(function(e) {
                var password = $("input[name='password']").val();
                var passwordConfirm = $("input[name='confirmPassword']").val();
                if (password == passwordConfirm) {
                    $("#confirmationMessage").html('<span class="text-success">Password matched</span>');
                } else {
                    $("#confirmationMessage").html(
                        '<span class="text-danger">Password did not match</span>');
                }
            });
        });
    </script>
@endpush
