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
    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
      <div class="pd-20 card-box height-100-p">
        <h4 class="text-center p-3">Create New Ledger</h4>
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
              <input name="parent_ledger" class="form-control" onkeyup="load_ledger_heads(event)" value="Primary-">
              <small class="text-danger font-weight-bold">After selecting the ledger from the dropdown menu, pleaes don't remove any character from the text-field.</small>
            </div>
            <div class="form-group col-md-12 col-12 d-none" id="name_of_group">
              <label for="">Name of Group:</label>
              <select name="name_of_group" class="form-control" style="width: 100%;height:38px;">
                <option value="General">General</option>
                <option value="Asset">Asset</option>
                <option value="Liabilities">Liabilities</option>
                <option value="Income">Income</option>
                <option value="Expense">Expense</option>
              </select>
            </div>
            <div class="form-group col-md-12 col-12 d-none" id="visibility_order">
              <label for="">Visibility Order:</label>
              <input type="number" min="1" name="visibility_order" class="form-control">
            </div>
            <div class="form-group col-md-12 col-12">
              <button type="submit" class="btn btn-success btn-md float-right">submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
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
                  <a href="{{ route('ledger-head.edit', $item->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="view or edit"><i
                      class="icon-copy dw dw-edit-1"></i></a>
                  <a href="{{ route('ledger-head.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                    onclick="return confirm('Deleting this head may affect your account information. Please verify your action before deleting this head.')" data-toggle="tooltip" data-placement="top"
                    title="delete-head"><i class="icon-copy dw dw-delete-3"></i></a>
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
      // Name of Group Selection for Primary Ledgers
      $("#ledger_parent").on("change", function() {
        let selectedLedger = $(this).find(":selected").val();
        if (selectedLedger == 0) {
          $("#name_of_group").removeClass('d-none');
          $("#visibility_order").removeClass('d-none');
        } else {
          $("#name_of_group").addClass('d-none');
          $("#visibility_order").addClass('d-none');
        }
      });
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
