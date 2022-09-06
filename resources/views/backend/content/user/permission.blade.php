@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
  @if (Request::routeIs('permission.index'))
    <div class="row">
      @can('add-permission')
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="pd-20 card-box height-100-p">
            <a href="javascript:void(0)" class="btn btn-info btn-md float-right mb-3" data-toggle="modal" data-target="#userModal"><i class="icon-copy dw dw-add"></i> add new</a>

            <!-- Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><i class="icon-copy dw dw-add"></i> Add New Permission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('permission.store') }}" method="post">
                      @csrf
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="">Permission:</label>
                          <input type="text" name="name" class="form-control" data-validation="required">
                          <small class="text-info">Use: [read-] | [add-] | [edit-] | [delete-] prefix before every permission</small>
                        </div>
                        <div class="form-group col-md-12">
                          <button type="submit" class="btn btn-success btn-md float-right"><i class="icon-copy dw dw-add"></i> add</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endcan
      <div class="col-md-12 mt-3">
        <div class="pd-20 card-box height-100-p">
          <table class="data-table table stripe hover nowrap">
            <thead>
              <tr>
                <th class="table-plus datatable-nosort">Name</th>
                <th class="datatable-nosort">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permissions as $item)
                <tr>
                  <td class="table-plus">{{ $item->name }}</td>
                  <td>
                    @can('edit-permission')
                      <a href="{{ route('permission.edit', $item->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="permission-edit"><i
                          class="icon-copy dw dw-edit2"></i></a>
                    @endcan
                    @can('delete-permission')
                      <a href="{{ route('permission.destroy', $item->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="permission-delete"
                        onclick="return confirm('Are you sure to remove this permission?')"><i class="icon-copy dw dw-delete-3"></i></a>
                    @endcan
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @else
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="pd-20 card-box height-100-p">
          <form action="{{ route('permission.update', $permission->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="">Permission:</label>
                <input type="text" name="name" class="form-control" value="{{ $permission->name }}" data-validation="required">
                <small class="text-info">Use: [add-] | [edit-] | [delete-] prefix before every permission</small>
              </div>
              <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success btn-md float-right"><i class="icon-copy dw dw-add"></i> update</button>
              </div>
            </div>
          </form>
          < </div>
        </div>
  @endif
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
    });
  </script>
@endpush
