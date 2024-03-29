@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css">
@endpush

@section('content')
  @include('backend.partial.date_setter')
  @if (Request::routeIs('report.balance-sheet.transactions'))
    <div class="row mt-5">
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
                <th>Narration</th>
                <th>Voucher Type</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="6">Balance:</td>
                <td>{{ $balance }}</td>
              </tr>
              @php
                $total_debit = 0;
                $total_credit = 0;
              @endphp
              @foreach ($transactions as $item)
                @php
                  if ($item->particular->value == 'Dr') {
                      $look_for_particular = 'Cr';
                  } else {
                      $look_for_particular = 'Dr';
                  }
                @endphp
                @foreach ($item->transaction->details as $detail)
                  @if ($ledgerHead->name != $detail->head->name && $detail->particular->value == $look_for_particular)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                      <td>{{ $detail->particular->value . ' ' . $detail->head->name }}</td>
                      <td>{{ $item->transaction->narration }}</td>
                      <td>
                        <a href="{{ route('report.balance-sheet.particular.transacation', $detail->transaction_id) }}" class="font-weight-bold">{{ $item->transaction->voucher->name }}</a>
                      </td>
                      <td>
                        @if ($detail->particular->value == 'Cr')
                          @if ($detail->amount < $item->amount)
                            {{ $detail->amount }}
                            @php
                              $balance = $balance + $detail->amount;
                              $total_credit = $total_credit + $detail->amount;
                            @endphp
                          @else
                            {{ $item->amount }}
                            @php
                              $balance = $balance + $item->amount;
                              $total_credit = $total_credit + $item->amount;
                            @endphp
                          @endif
                        @endif
                      </td>
                      <td>
                        @if ($detail->particular->value == 'Dr')
                          @if ($detail->amount < $item->amount)
                            {{ $detail->amount }}
                            @php
                              $balance = $balance - $detail->amount;
                              $total_debit = $total_debit + $detail->amount;
                            @endphp
                          @else
                            {{ $item->amount }}
                            @php
                              $balance = $balance - $item->amount;
                              $total_debit = $total_debit + $item->amount;
                            @endphp
                          @endif
                        @endif
                      </td>
                      <td>{{ $balance }}</td>
                    </tr>
                  @endif
                @endforeach
              @endforeach
              <tr>
                <td colspan="4" class="text-right font-weight-bold">Total:</td>
                <td class="font-weight-bold">{{ $total_credit }}</td>
                <td class="font-weight-bold">{{ $total_debit }}</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @else
    {{-- Specific transaction/voucher entries --}}
    <div class="row mt-5">
      <div class="col-md-12 col-12">
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
                <tr>
                  <td>{{ Carbon::parse($item->date)->format('d-m-Y') }}</td>
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
                <td colspan="3">
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
              <tr>
                <td colspan="5">
                  @can('delete-voucher')
                    <a href="{{ route('voucher.accounting.destroy', $transaction->id) }}" class="btn btn-sm btn-danger float-right"
                      onclick="return confirm('Deleting this voucher will remove every transaction. Are you sure to proceed?')"><i class="icon-copy dw dw-trash1"></i> Delete Voucher</a>
                  @endcan
                  @can('edit-voucher')
                    <a href="javascript:void(0)" class="btn btn-warning btn-sm float-right mr-2" data-toggle="modal" data-target="#journal-edit-modal" type="button"><i class="icon-copy dw dw-edit-1"></i>
                      Edit
                      Voucher</a>
                  @endcan
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    {{-- edit voucher modal --}}
    <div class="modal fade bs-example-modal-xl" id="journal-edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              Edit Voucher - Database ID #{{ $transaction->id }}
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              ×
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('voucher.accounting.update', $transaction->id) }}" method="post" id="voucherForm">
              @csrf
              @method('PATCH')
              <div class="form-row">
                <div class="form-group col-md-12 col-12">
                  <label for="">Change Period:</label>
                  <input type="text" name="date" class="form-control date-picker" autocomplete="off" value="{{ $transaction->date }}">
                </div>
                <div class="col-sm-12 col-md-12">
                  <table class="table table-striped">
                    <thead>
                      <tr role="row">
                        <th>Particulars</th>
                        <th>Type</th>
                        <th>Voucher Type</th>
                        <th>Debit</th>
                        <th>Credit</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($transactions as $item)
                        <tr>
                          <td>
                            {{ $item->head->head_code . ' (' . $item->head->name . ')' }}
                            <input type="hidden" name="particular[]" value="{{ $item->id }}">
                          </td>
                          <td><input type="text" name="type[]" class="form-control" value="{{ $item->particular->value }}" readonly></td>
                          <td>
                            {{ $item->transaction->voucher->name }}
                          </td>
                          <td>
                            @if ($item->particular->value == 'Dr')
                              <input type="text" name="amounts[]" value="{{ $item->amount }}" class="debit_amount form-control" onkeyup="amountCalculation()">
                            @endif
                          </td>
                          <td>
                            @if ($item->particular->value == 'Cr')
                              <input type="text" name="amounts[]" value="{{ $item->amount }}" class="credit_amount form-control" onkeyup="amountCalculation()">
                            @endif
                          </td>
                        </tr>
                      @endforeach
                      <tr>
                        <td colspan="3">
                          <label for="">Narration:
                            <b>{{ $transactions->first()->transaction->narration }}</b></label>
                        </td>
                        <td id="debitAmount">
                          {{ $transactions->where('particular', App\Enums\ParticularType::Debit)->sum('amount') }}
                        </td>
                        <td id="creditAmount">
                          {{ $transactions->where('particular', App\Enums\ParticularType::Credit)->sum('amount') }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-12 col-md-12">
                  <button class="btn btn-success float-right" type="button" onclick="submitVoucherForm()">Update Voucher</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>
  <script>
    // calculate the amount
    function amountCalculation() {
      let totalDebit = 0,
        totalCredit = 0;
      $(".debit_amount").each(function() {
        totalDebit += parseInt(this.value);
      });
      $(".credit_amount").each(function() {
        totalCredit += parseInt(this.value);
      });
      $("#debitAmount").text(totalDebit);
      $("#creditAmount").text(totalCredit);
    }
    // check the dr/cr and submit the form
    function submitVoucherForm() {
      let debitAmount = parseInt($("#debitAmount").text());
      let creditAmount = parseInt($("#creditAmount").text());

      if (debitAmount != creditAmount) {
        Swal.fire({
          title: 'Debit/Credit Amount Mismatched!',
          text: 'Please check your voucher again.',
          icon: 'error',
          confirmButtonText: 'Okay!'
        })
      } else {
        $("#voucherForm").submit();
      }
    }
  </script>
@endpush
