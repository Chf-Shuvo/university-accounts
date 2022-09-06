@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
  {{-- @include('backend.partial.preLoader') --}}
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-20 text-right">
      <div class="pd-20 card-box height-100-p">
        <a href="{{ route('ledger-head.type', 'single') }}" class="btn btn-info btn-md">Single Ledgers</a>
        <a href="{{ route('ledger-head.type', 'group') }}" class="btn btn-primary btn-md">Group Ledgers</a>
      </div>
    </div>
    @can('add-ledger')
      <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
        <div class="pd-20 card-box height-100-p">
          <h4 class="text-center p-3">Create New Ledger</h4>
          <form action="{{ route('ledger-head.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-4 col-12">
                <label for="">Ledger Head Code:</label>
                <input type="text" class="form-control" name="head_code">
              </div>
              <div class="form-group col-md-4 col-12">
                <label for="">Ledger Head Name:</label>
                <input type="text" class="form-control" data-validation="required" name="name">
                <small class="text-danger"><b>Don't use special characters like (~,#,$,/,\) in your LEDGER HEAD NAME.</b></small>
              </div>
              <div class="form-group col-md-4 col-12">
                <label for="">Visibility Order:</label>
                <input type="number" class="form-control" name="visibility_order" min="1" value="1">
                <small class="text-danger font-weight-bold">Use this order if you are assigning this head under another head.</small>
              </div>
              <div class="form-group col-md-6 col-12">
                <label for="">Under:</label>
                <input name="parent_ledger" class="form-control" onkeyup="load_ledger_heads(event)" value="Primary~">
                <small class="text-danger font-weight-bold">After selecting the ledger from the dropdown menu, pleaes don't remove any character from the text-field.</small>
              </div>
              <div class="form-group col-md-6 col-12">
                <label for="">Name of Group:</label>
                <select name="name_of_group" class="form-control" style="width: 100%;height:40px;">
                  <option value="{{ NameOfGroup::General->value }}">{{ NameOfGroup::General->value }}</option>
                  <option value="{{ NameOfGroup::Asset->value }}">{{ NameOfGroup::Asset->value }}</option>
                  <option value="{{ NameOfGroup::Liability->value }}">{{ NameOfGroup::Liability->value }}</option>
                  <option value="{{ NameOfGroup::Income->value }}">{{ NameOfGroup::Income->value }}</option>
                  <option value="{{ NameOfGroup::Expense->value }}">{{ NameOfGroup::Expense->value }}</option>
                </select>
                <small class="text-danger font-weight-bold">If this head is under Primary then select the Name of Group.</small>
              </div>
              <div class="form-group col-md-12 col-12">
                <button type="submit" class="btn btn-success btn-md float-right">submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    @endcan
    <div class="col-lg-12 col-md-12 col-sm-12 my-3 d-flex justify-content-end">
      <div class="pd-20 card-box height-100-p">
        {{ $items->links() }}
      </div>
    </div>
    <div class="col-md-12 col-12">
      <div class="pd-20 card-box height-100-p">
        <table class="data-table-no-pagination table stripe hover nowrap">
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
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->head_code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->parent }}</td>
                <td>{{ $item->name_of_group->value }}</td>
                <td>
                  @can('edit-ledger')
                    <a href="{{ route('ledger-head.edit', $item->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="view or edit"><i
                        class="icon-copy dw dw-edit-1"></i></a>
                  @endcan
                  @can('delete-ledger')
                    <a href="{{ route('ledger-head.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                      onclick="return confirm('Deleting this head may affect your account information. Please verify your action before deleting this head.')" data-toggle="tooltip" data-placement="top"
                      title="delete-head"><i class="icon-copy dw dw-delete-3"></i></a>
                  @endcan
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
  {{-- in page scripts --}}
  <script>
    $(document).ready(function() {
      $.validate();
    });
    // load the ledgers
    function load_ledger_heads(event) {
      let keyword = event.target.value;
      $.ajax({
        type: "get",
        url: "{{ route('report.display.ledger.get') }}",
        data: {
          "keyword": keyword
        },
        dataType: "json",
        success: function(response) {
          $(event.target).autocomplete({
            source: response
          });
        }
      });
    }
  </script>
@endpush
