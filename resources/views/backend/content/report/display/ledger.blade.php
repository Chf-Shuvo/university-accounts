@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css">
@endpush

@section('content')
  @include('backend.partial.loading')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
      <div class="pd-20 card-box height-100-p">
        <div class="form-group">
          <label for="">Ledger Head:</label>
          <input type="text" class="form-control" name="ledger_head" id="ledger_head" onkeyup="load_ledger_heads()">
          <button type="button" class="btn btn-success float-right my-3" onclick="load_ledger()">generate-ledger</button>
        </div>
      </div>
    </div>
    {{-- student ledger --}}
    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
      <div class="pd-20 card-box height-100-p" id="student_ledger">
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>
  <script>
    function load_ledger_heads() {
      let keyword = $('#ledger_head').val();
      $.ajax({
        type: "get",
        url: "{{ route('report.display.ledger.get') }}",
        data: {
          "keyword": keyword
        },
        dataType: "json",
        success: function(response) {
          $('#ledger_head').autocomplete({
            source: response
          });
        }
      });
    }

    function load_ledger() {
      $('#loading_screen').removeClass('d-none');
      let ledger_head = $('#ledger_head').val();
      if (ledger_head === '') {
        Swal.fire({
          title: 'Invalid Action!',
          text: 'Please type the ledger account again!',
          icon: 'error',
          confirmButtonText: 'Okay!'
        })
      } else {
        let url = "{{ route('report.balance-sheet.transactions', ':ledger_head') }}";
        url = url.replace(':ledger_head', ledger_head);
        $.ajax({
          type: "get",
          url: url,
          dataType: "html",
          success: function(response) {
            $('#student_ledger').html(response);
            $('#loading_screen').addClass('d-none');
          }
        });
      }
    }
  </script>
@endpush
