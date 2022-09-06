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
           <th>Voucher Type</th>
           <th>Debit</th>
           <th>Credit</th>
         </tr>
       </thead>
       <tbody>
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
                 <td>
                   <a href="{{ route('report.balance-sheet.particular.transacation', $detail->transaction_id) }}" class="font-weight-bold">{{ $item->transaction->voucher->name }}</a>
                 </td>
                 <td>
                   @if ($detail->particular->value == 'Cr')
                     @if ($detail->amount < $item->amount)
                       {{ $detail->amount }}
                     @else
                       {{ $item->amount }}
                     @endif
                   @endif
                 </td>
                 <td>
                   @if ($detail->particular->value == 'Dr')
                     @if ($detail->amount < $item->amount)
                       {{ $detail->amount }}
                     @else
                       {{ $item->amount }}
                     @endif
                   @endif
                 </td>
               </tr>
             @endif
           @endforeach
         @endforeach
         <tr>
           <td colspan="3">Closing Balance:</td>
           <td>
             @if ($closing_balance > 0)
               {{ $closing_balance }}
             @endif
           </td>
           <td>
             @if ($closing_balance < 0)
               {{ $closing_balance }}
             @endif
           </td>
         </tr>
       </tbody>
     </table>
   </div>
 </div>
