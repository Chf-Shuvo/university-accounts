@extends('backend.layout.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
    <div class="row align-items-center">
        <div class="col-md-12">
            <a href="javascript:void(0)" class="btn btn-info btn-md float-right" data-toggle="modal"
                data-target="#userModal"><i class="icon-copy dw dw-add-user"></i> add new</a>

            <!-- Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="icon-copy dw dw-add-user"></i> Add New User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('user-profile.store') }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-12">
                                        <label for="">Select Company</label>
                                        <select name="company" class="form-control" data-validation="required">
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">User Name:</label>
                                        <input type="text" name="name" class="form-control" data-validation="required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">User Email:</label>
                                        <input type="email" name="email" class="form-control" data-validation="email">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">User Contact:</label>
                                        <input type="text" name="contact" class="form-control" data-validation="number">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Password:</label>
                                        <input type="password" name="password" class="form-control"
                                            data-validation="required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Confirm Password:</label>
                                        <input type="password" name="confirmPassword" class="form-control"
                                            data-validation="required">
                                        <div class="pt-2" id="confirmationMessage"></div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-success btn-md float-right"><i
                                                class="icon-copy dw dw-add-user"></i> add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td class="table-plus">{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->contact }}</td>
                            <td>
                                <a href="{{ route('user-profile.edit', auth()->user()->id) }}"
                                    class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                    title="user-edit"><i class="icon-copy dw dw-edit2"></i></a>
                                <a href="{{ route('user-profile.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                                    data-toggle="tooltip" data-placement="top" title="user-delete"
                                    onclick="return confirm('Are you sure to remove this user?')"><i
                                        class="icon-copy dw dw-delete-3"></i></a>
                                <a href="{{ route('permission.create', $item->id) }}" class="btn btn-info btn-sm"
                                    data-toggle="tooltip" data-placement="top" title="manage-permissions"><i
                                        class="icon-copy dw dw-settings1"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/scripts/datatable-setting.js') }}"></script>
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
