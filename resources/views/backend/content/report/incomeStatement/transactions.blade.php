@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
@endpush
@section('content')
  @include('backend.partial.preLoader')
  @if (Request::routeIs('report.income.transactions'))
    <div class="row">
      <div class="col-md-12 col-12">
          <div class="pd-20 card-box height-100-p">
              <h4 class="text-center py-3">{{$ledgerHead->name}}</h4>
              <table class="table table-striped data-table-export">
                  <thead>
                  <tr role="row">
                      <th>Particulars</th>
                      <th>Date</th>
                      <th>Voucher Type</th>
                      <th>Debit</th>
                      <th>Credit</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($transactions as $item)
                      <tr>
                          <td>{{ $item->head->name }}</td>
                          <td>{{ Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                          <td>
                              <a href="{{ route('report.income.particular.transacation', $item->transaction_id) }}" class="font-weight-bold">{{ $item->transaction->voucher->name }}</a>
                          </td>
                          <td>
                              @if ($item->particular->value == 'Dr')
                                  {{ $item->amount }}
                              @endif
                          </td>
                          <td>
                              @if ($item->particular->value == 'Cr')
                                  {{ $item->amount }}
                              @endif
                          </td>
                      </tr>
                  @endforeach
                  <tr>
                      <td colspan="3">
                          <label for="">Closing Balance:
                              <b>{{ $transactions->where('particular', App\Enums\ParticularType::Credit)->sum('amount') - $transactions->where('particular', App\Enums\ParticularType::Debit)->sum('amount') }}</b></label>
                      </td>
                      <td>
                          {{ $transactions->where('particular', App\Enums\ParticularType::Debit)->sum('amount') }}
                      </td>
                      <td>
                          {{ $transactions->where('particular', App\Enums\ParticularType::Credit)->sum('amount') }}
                      </td>
                  </tr>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  @else
    <div class="row">
      <div class="col-md-12 col-12">
          <div class="pd-20 card-box height-100-p">
              <h4 class="text-center py-3">{{$ledgerHead->name}}</h4>
              <table class="table table-striped data-table-export">
                  <thead>
                  <tr role="row">
                      <th>Particulars</th>
                      <th>Voucher Type</th>
                      <th>Debit</th>
                      <th>Credit</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($transactions as $item)
                      <tr>
                          <td>{{ $item->head->name }}</td>
                          <td>
                              {{ $item->transaction->voucher->name }}
                          </td>
                          <td>
                              @if ($item->particular->value == 'Dr')
                                  {{ $item->amount }}
                              @endif
                          </td>
                          <td>
                              @if ($item->particular->value == 'Cr')
                                  {{ $item->amount }}
                              @endif
                          </td>
                      </tr>
                  @endforeach
                  <tr>
                      <td colspan="2">
                          <label for="">Narration:
                              <b>{{ $transactions->first()->transaction->narration }}</b></label>
                      </td>
                      <td>
                          {{ $transactions->where('particular', App\Enums\ParticularType::Debit)->sum('amount') }}
                      </td>
                      <td>
                          {{ $transactions->where('particular', App\Enums\ParticularType::Credit)->sum('amount') }}
                      </td>
                  </tr>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  @endif
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
@endpush
