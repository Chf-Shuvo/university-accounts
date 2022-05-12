@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
@endpush

@section('content')
  {{-- @include('backend.partial.preLoader') --}}
  <div class="row mt-5">
    <div class="col-md-12 col-12">
      <table class="data-table-export table table-striped">
        <thead>
          <tr>
            <th colspan="4"></th>
            <th class="text-center">{{ $particular->name }} <br>
              {{ auth()->user()->company_name }} <br>
              <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#dateModal">From {{ Carbon\Carbon::parse(Calculation::start_date())->format('d/m/Y') }} To
                {{ Carbon\Carbon::parse(Calculation::end_date())->format('d/m/Y') }}</a>
            </th>
          </tr>
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
          @foreach ($particular->particulars as $item)
            <tr>
              <td>
                @if ($item->has_child > 0)
                  <a href="{{ route('report.balance-sheet.particurlars', $item->id) }}"><b>{{ $item->name }}</b></a>
                @else
                  <a href="{{ route('report.balance-sheet.transactions', $item->id) }}"><b>{{ $item->name }}</b></a>
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
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  {{-- modal --}}
  <div class="modal fade dateModal" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel" style="font-family: Inter, Bangla539, sans-serif;">Change Period</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <form action="{{ route('period.change') }}" method="post">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">From:</label>
                <input type="text" class="form-control date-picker" name="from" autocomplete="off" required onkeydown="return false">
              </div>
              <div class="form-group col-md-6">
                <label for="">To:</label>
                <input type="text" class="form-control date-picker" name="to" autocomplete="off" required onkeydown="return false">
              </div>
              <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success float-right">submit</button>
              </div>
            </div>
          </form>
        </div>
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
