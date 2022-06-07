@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 text-right mb-3">
      <div class="pd-20 card-box height-100-p">
        <a href="javascript:void(0)" class="btn btn-info btn-md" data-toggle="modal" data-target="#dataModal"><i class="icon-copy dw dw-add"></i> add new voucher type</a>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="pd-20 card-box height-100-p">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th>Database ID</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($vouchers as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>
                  <a href="{{ route('voucher.manage.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="icon-copy dw dw-edit-1"></i></a>
                  <a href="{{ route('voucher.manage.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                    onclick="return confirm('Deleting this head may affect your account information. Please verify your action before deleting this head.')"><i class="icon-copy dw dw-delete-3"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  {{-- modal --}}
  <div class="modal fade bs-example-modal-lg" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Create New Voucher-Type</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <form action="{{ route('voucher.manage.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-12 col-12">
                <label for="">Voucher Type Title:</label>
                <input type="text" class="form-control" name="name" placeholder="Journal/Bank Payment/Cash Payment" data-validation="required">
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
  <script src="{{ asset('backend/vendors/scripts/datatable-setting.js') }}"></script>
  </body>
  {{-- page scripts --}}
  <script>
    $(document).ready(function() {
      $.validate();
    });
  </script>
@endpush
