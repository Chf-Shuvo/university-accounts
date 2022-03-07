@extends('backend.layout.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
    @if (Request::routeIs('audit.index'))
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <form action="{{ route('audit.get') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Check Audit of:</label>
                            <select class="custom-select2 form-control" name="model" style="width: 100%; height: 38px;" data-validation="required">
                                <option selected disabled>Choose..</option>
                                @foreach ($models as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <small class="text-info">Select a single feature to pull all the records of that feature.</small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">From:</label>
                            <input name="from" class="form-control date-picker" placeholder="Select From Date" type="text" data-validation="required">
                            <small class="text-info">Select the start date of the range.</small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">To:</label>
                            <input name="to" class="form-control date-picker" placeholder="Select To Date" type="text" data-validation="required">
                            <small class="text-info">Select the ends date of the range.</small>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-success float-right">get-audits</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <table class="data-table-export table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>Action Taken In</th>
                            <th>Action Taken By</th>
                            <th>Action</th>
                            <th>Previous Value</th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($audits as $item)
                            @php
                                $oldValue = json_decode($item->old_values);
                                $newValue = json_decode($item->new_values);
                            @endphp
                            <tr>
                                <td class="table-plus">{{ $model }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->event }}</td>
                                <td>
                                    @foreach ($oldValue as $old)
                                        {{ $old }} <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($newValue as $new)
                                        {{ $new }} <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    
@endsection

@push('js')
    {{-- datatable core --}}
    <script src="{{ asset('backend/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- datatable buttons --}}
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
	<script src="{{ asset('backend/src/plugins/datatables/js/vfs_fonts.js') }}"></script>
    {{-- datatable initiate --}}
	<script src="{{ asset('backend/vendors/scripts/datatable-setting.js') }}"></script>
    {{-- others --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
    <script>
        $(document).ready(function () {
            $.validate();
        });
    </script>
@endpush