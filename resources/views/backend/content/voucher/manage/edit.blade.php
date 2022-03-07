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
            <form action="{{ route('voucher.manage.update', $manage->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-row">
                    <div class="form-group col-md-12 col-12">
                        <label for="">Voucher Type Title:</label>
                        <input type="text" class="form-control" name="name" value="{{ $manage->name }}"
                            data-validation="required">
                    </div>

                    <div class="form-group col-md-12 col-12">
                        <button type="submit" class="btn btn-success btn-md float-right">submit</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
    {{-- page scripts --}}
    <script>
        $(document).ready(function() {
            $.validate();
        });
    </script>
@endpush
