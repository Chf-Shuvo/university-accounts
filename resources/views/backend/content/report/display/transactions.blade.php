 <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-4">
     <h4>{{ auth()->user()->company_name }}</h4>
     <span>{{ auth()->user()->company_address }}</span>
     <h4>{{ $ledgerHead->head_code }} ({{ $ledgerHead->name }})</h4>
     <span>Ledger Account</span>
     <br>
     <br>
     <span>{{ Carbon::parse(session()->get('start_date'))->format('d-M-Y') }} - {{ Carbon::parse(session()->get('end_date'))->format('d-M-Y') }}</span>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12">
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
