@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css">
@endpush

@section('content')
  @include('backend.partial.validationError')
  <div class="row">
    <div class="col-md-12 col-12 text-center mb-3">
      <div class="pd-20 card-box height-100-p">
        <h2>Account Vouchers</h2>
      </div>
    </div>
    <div class="col-md-12 col-12">
      <div class="pd-20 card-box height-100-p">
        <form action="{{ route('voucher.accounting.store') }}" method="post" enctype="multipart/form-data" id="voucherForm">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-12 col-12">
              <label for="">Period:</label>
              <input type="text" name="date" class="form-control date-picker" autocomplete="off" id="entryPeriod" value="{{ Carbon::now()->format('Y-m-d') }}">
            </div>
            <div class="form-group col-md-12 col-12">
              <label for="">Voucher Type Title:</label>

              <select name="voucher_type" id="" class="form-control custom-select2" style="width: 100%">
                @foreach ($vouchers as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-12">
              <table class="table table-bordered" id="dynamicTable">
                <tr>
                  <th>Particulars</th>
                  <th>List of Ledger Accounts</th>
                  <th>Amount</th>
                </tr>
                <tr class="dataRow">
                  <td><select name="account_type[]" id="" class="form-control accountType" onchange="amountCalculation()">
                      <option value="Dr" selected>Dr</option>
                      <option value="Cr">Cr</option>
                    </select></td>
                  <td><select name="particular[]" id="" class="form-control ledgerSelect" style="width: 100%">
                      <option></option>
                      @foreach ($ledgerHeads as $head)
                        <option value="{{ $head->id }}">{{ $head->name }}@if ($head->alias != null)
                            @foreach ($head->alias as $alias_ledger)
                              / {{ $alias_ledger->name }}
                            @endforeach
                          @endif
                        </option>
                      @endforeach
                    </select></td>
                  <td><input type="number" name="amount[]" placeholder="Amount" class="form-control amountField" value="0" onkeyup="amountCalculation()" /></td>
                </tr>
                <tr>
                  <td>
                    Narration:
                  </td>
                  <td>
                    <textarea name="narration" class="form-control"></textarea>
                  </td>
                  <td>
                    <span class="font-weight-bold">Debit: <span id="debitAmount"></span></span>
                    <span class="font-weight-bold float-right">Credit: <span id="creditAmount"></span></span>
                    <input type="hidden" name="total_amount" id="total_amount">
                  </td>
                </tr>
              </table>
              <button type="button" id="remove" class="btn btn-danger float-right ml-2" data-toggle="tooltip" data-placement="top" title="remove last Dr/Cr entry field"><i
                  class="icon-copy dw dw-cancel"></i>
                Particular</button>
              <button type="button" id="add" class="btn btn-success float-right" data-toggle="tooltip" data-placement="top" title="add new Dr/Cr entry field"><i class="icon-copy dw dw-add"></i>
                Particular</button>
            </div>

            <div class="form-group col-md-12 col-12 mt-3">
              <button type="button" class="btn btn-success btn-md float-right" onclick="submitVoucherForm()">submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  @endsection

  @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    {{-- page scripts --}}
    <script>
      $(document).ready(function() {
        $.validate();
        $(".ledgerSelect").select2({
          placeholder: "Select....."
        });
      });
    </script>
    {{-- row cloning --}}
    <script>
      $("#add").click(function(e) {
        amountCalculation();
        let debitAmount = parseInt($("#debitAmount").text());
        let creditAmount = parseInt($("#creditAmount").text());

        if (debitAmount == 0 || creditAmount == 0 || debitAmount != creditAmount) {
          $(".ledgerSelect").select2("destroy");
          $(".dataRow").eq(0).clone()
            .find("input")
            .val(0)
            .end()
            .show()
            .insertAfter(".dataRow:last");
          $(".ledgerSelect").each(function() {
            $(this).removeAttr('data-select2-id');
            $(this).select2({
              placeholder: "Select....."
            });
          });
        } else {
          Swal.fire({
            title: 'Debit/Credit Amount Matched!',
            text: 'Voucher Entry Completed, you can submit the voucher for next procedure.',
            icon: 'success',
            confirmButtonText: 'Okay!'
          })
        }
      });
      $("#remove").click(function(e) {
        let count = $(".dataRow").length;
        if (count > 1) {
          $(".dataRow:last").remove();
        }
      });
    </script>
    <script src="{{ asset('backend/custom/js/voucher_calculation.js') }}"></script>
    <script>
      // function from voucher_calculation.js
      amountCalculation();
      // submit the form
      function submitVoucherForm() {
        let debitAmount = parseInt($("#debitAmount").text());
        let creditAmount = parseInt($("#creditAmount").text());
        let selectedEntryDate = $("#entryPeriod").val();
        let permittedEntryDate =
          "{{ auth()->user()->company_last_entry_date }}"
        let dateCheck = moment(selectedEntryDate).isSameOrBefore(permittedEntryDate);
        if (debitAmount === creditAmount) {
          $("#total_amount").val(debitAmount);
          if (dateCheck) {
            if (debitAmount === 0 || creditAmount === 0) {
              Swal.fire({
                title: 'Entry Restricted!',
                text: 'Cannot create entries with 0 amount!',
                icon: 'error',
                confirmButtonText: 'Okay!'
              })
            } else {
              $("#voucherForm").submit();
            }
          } else {
            Swal.fire({
              title: 'Entry Restricted!',
              text: 'You are not allowed to make an entry selecting post permitted date! Please change your period or extend Last Entry Date from user profile settings.',
              icon: 'error',
              confirmButtonText: 'Okay!'
            })
          }
        } else {
          Swal.fire({
            title: 'Debit/Credit Amount Mismatched!',
            text: 'Please check your voucher again.',
            icon: 'error',
            confirmButtonText: 'Okay!'
          })
        }
      }
    </script>
  @endpush
