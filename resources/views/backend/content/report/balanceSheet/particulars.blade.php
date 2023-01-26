@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
@endpush

@section('content')
  {{-- @include('backend.partial.preLoader') --}}
  @include('backend.partial.date_setter')
  <div class="row mt-5">
    <div class="col-md-12 col-12">
      <div class="pd-20 card-box height-100-p">
          <h4 class="text-center py-3">{{$particular->name}}</h4>
        <table class="data-table-export table table-striped">
          <thead>
            <tr>
              <th>Particulars</th>
              <th>Alias Ledgers</th>
              <th>Opening Balance</th>
              <th>Debit</th>
              <th>Credit</th>
              <th>Closing Balance</th>
            </tr>
          </thead>
          <tbody>
            @php
              $total_opening = 0;
              $total_debit = 0;
              $total_credit = 0;
              $total_closing = 0;
            @endphp
            @foreach ($particular->particulars as $item)
              <tr>
                <td>
                  @if ($item->has_child > 0)
                    <a href="{{ route('report.balance-sheet.particurlars', [$type, $item->id]) }}"><b>{{ $item->name }}</b></a>
                  @else
                    <a href="{{ route('report.balance-sheet.transactions', $item->name) }}"><b>{{ $item->name }}</b></a>
                  @endif
                </td>
                <td>
                  <ul>
                    @foreach ($item->alias as $alias_ledger)
                      <li>{{ $alias_ledger->name }}</li>
                    @endforeach
                  </ul>
                </td>
                <td>{{ $item->transaction_summary['openning'] }}</td>
                <td>{{ $item->transaction_summary['debit'] }}</td>
                <td>{{ $item->transaction_summary['credit'] }}</td>
                <td>{{ $item->transaction_summary['closing'] }}</td>
              </tr>
              @php
                $total_opening = $total_opening + $item->transaction_summary['openning'];
                $total_debit = $total_debit + $item->transaction_summary['debit'];
                $total_credit = $total_credit + $item->transaction_summary['credit'];
                $total_closing = $total_closing + $item->transaction_summary['closing'];
              @endphp
            @endforeach
            <tr>
              <td><b>Total:</b></td>
              <td></td>
              <td>{{ $total_opening }}</td>
              <td>{{ $total_debit }}</td>
              <td>{{ $total_credit }}</td>
              <td>{{ $total_closing }}</td>
            </tr>
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
  </body>
@endpush
