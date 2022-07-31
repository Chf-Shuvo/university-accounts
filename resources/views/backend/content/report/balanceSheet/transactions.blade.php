@extends('backend.layout.master')

@section('content')
  @if (Request::routeIs('report.balance-sheet.transactions'))
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-4">
        <div class="pd-20 card-box height-100-p">
          <h4>{{ auth()->user()->company_name }}</h4>
          <span>{{ auth()->user()->company_address }}</span>
          <h4>{{ $ledgerHead->head_code }} ({{ $ledgerHead->name }})</h4>
          <span>Ledger Account</span>
          <br>
          <br>
          <span>{{ Carbon::parse(session()->get('start_date'))->format('d-M-Y') }} - {{ Carbon::parse(session()->get('end_date'))->format('d-M-Y') }}</span>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="pd-20 card-box height-100-p">
          <table class="table table-striped">
            <thead>
              <tr role="row">
                <th>Date</th>
                <th>Particulars</th>
                <th>Voucher Type</th>
                <th>Debit</th>
                <th>Credit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transactions as $item)
                @foreach ($item->transaction->details as $detail)
                  @if ($ledgerHead->name != $detail->head->name)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                      <td>{{ $detail->particular->value . ' ' . $detail->head->name }}</td>
                      <td>
                        <a href="{{ route('report.balance-sheet.particular.transacation', $detail->transaction_id) }}" class="font-weight-bold">{{ $item->transaction->voucher->name }}</a>
                      </td>
                      <td>
                        @if ($detail->particular->value == 'Cr')
                          {{ $detail->amount }}
                        @endif
                      </td>
                      <td>
                        @if ($detail->particular->value == 'Dr')
                          {{ $detail->amount }}
                        @endif
                      </td>
                    </tr>
                  @endif
                @endforeach

                {{-- <tr>
                  <td>{{ Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                  @foreach ($item->transaction->details as $detail)
                    @if ($detail->particular->value == 'Cr')
                      <td>{{ $item->particular->value . ' ' . $item->head->name }}</td>
                    @endif
                  @endforeach
                  <td>
                    <a href="{{ route('report.balance-sheet.particular.transacation', $item->transaction_id) }}" class="font-weight-bold">{{ $item->transaction->voucher->name }}</a>
                  </td>
                  <td>
                    @if ($item->particular->value == 'Cr')
                      {{ $item->amount }}
                    @endif
                  </td>
                  <td>
                    @if ($item->particular->value == 'Dr')
                      {{ $item->amount }}
                    @endif
                  </td>
                </tr> --}}
              @endforeach
              <tr>
                <td colspan="3">
                  <label for="">Closing Balance:
                    <b>{{ $transactions->where('particular', App\Enums\ParticularType::Credit)->sum('amount') - $transactions->where('particular', App\Enums\ParticularType::Debit)->sum('amount') }}</b></label>
                </td>
                <td>
                  {{ $transactions->where('particular', App\Enums\ParticularType::Credit)->sum('amount') }}
                </td>
                <td>
                  {{ $transactions->where('particular', App\Enums\ParticularType::Debit)->sum('amount') }}
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
          <table class="table table-striped">
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
                  <td>{{ $item->head->head_code . ' (' . $item->head->name . ')' }}</td>
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
