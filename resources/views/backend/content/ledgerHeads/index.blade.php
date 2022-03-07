@extends('backend.layout.master')

@push('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <a href="javascript:void(0)" class="btn btn-info btn-md m-3 float-right" data-toggle="modal"
                data-target="#dataModal"><i class="icon-copy dw dw-add"></i> add new head</a>
            <div class="modal fade bs-example-modal-lg" id="dataModal" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Create New Ledger-Head</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('ledger-head.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="">Ledger Head Code:</label>
                                        <input type="text" class="form-control" name="head_code">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label for="">Ledger Head Name:</label>
                                        <input type="text" class="form-control" data-validation="required" name="name">
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label for="">Under:</label>
                                        <select name="parent_id" class="custom-select2 form-control"
                                            style="width: 100%;height:38px">
                                            <option value="0" selected>Master Head</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <button type="submit" class="btn btn-success btn-md float-right">submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th>Database ID</th>
                        <th>Account Code</th>
                        <th>Name</th>
                        <th>Under</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->head_code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->parent }}</td>
                            <td>
                                <a href="{{ route('ledger-head.edit', $item->id) }}" class="btn btn-warning btn-sm"><i
                                        class="icon-copy dw dw-edit-1"></i></a>
                                <a href="{{ route('ledger-head.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deleting this head may affect your account information. Please verify your action before deleting this head.')"><i
                                        class="icon-copy dw dw-delete-3"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- buttons for Export datatable -->
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/vfs_fonts.js') }}"></script>
    <!-- Datatable Setting js -->
    <script src="{{ asset('backend/vendors/scripts/datatable-setting.js') }}"></script></body>
    {{-- in page scripts --}}
    <script>
        $(document).ready(function() {
            $.validate();
            $(".custom-select2").select2({
                dropdownParent: $("#dataModal")
            });
        });
    </script>
@endpush
