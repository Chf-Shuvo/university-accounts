@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
@endpush

@section('content')
  @include('backend.partial.preLoader')

  <div class="row">
    @if ($type == 'single')
      <div class="col-lg-12 col-md-12 col-sm-12 mb-20 d-flex justify-content-end">
        <div class="pd-20 card-box height-100-p">
          {{ $items->links() }}
        </div>
      </div>
    @endif
    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
      <div class="pd-20 card-box height-100-p">
        <h5 class="text-info text-center p-3 text-uppercase">{{ $type }} - ledgers</h5>
        <table class="table data-table-no-pagination stripe hover nowrap">
          <thead>
            <tr>
              <th>Database ID</th>
              <th>Account Code</th>
              <th>Name</th>
              <th>Under</th>
              <th>Name of Group</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
              @if ($type == 'single')
                @if ($item->has_child == 0)
                  <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->head_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->parent }}</td>
                    <td>{{ $item->name_of_group->value }}</td>
                    <td>
                      <a href="{{ route('ledger-head.edit', $item->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="view or edit"><i
                          class="icon-copy dw dw-edit-1"></i></a>
                      <a href="{{ route('ledger-head.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                        onclick="return confirm('Deleting this head may affect your account information. Please verify your action before deleting this head.')" data-toggle="tooltip"
                        data-placement="top" title="delete-head"><i class="icon-copy dw dw-delete-3"></i></a>
                    </td>
                  </tr>
                @endif
              @else
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->head_code }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->parent }}</td>
                  <td>{{ $item->name_of_group->value }}</td>
                  <td>
                    <a href="{{ route('ledger-head.edit', $item->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="view or edit"><i
                        class="icon-copy dw dw-edit-1"></i></a>
                    <a href="{{ route('ledger-head.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                      onclick="return confirm('Deleting this head may affect your account information. Please verify your action before deleting this head.')" data-toggle="tooltip" data-placement="top"
                      title="delete-head"><i class="icon-copy dw dw-delete-3"></i></a>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('js')
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
  {{-- in page scripts --}}
@endpush
