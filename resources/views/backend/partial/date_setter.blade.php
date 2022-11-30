 <div class="row mt-5">
   <div class="col-md-12 col-12">
     <div class="pd-20 card-box height-100-p">
       <h5 class="text-center p-3">Showing Results From {{ Carbon\Carbon::parse(Calculation::start_date())->format('d M Y') }} To
         {{ Carbon\Carbon::parse(Calculation::end_date())->format('d M Y') }}</h5>
       <form action="{{ route('period.change') }}" method="post">
         @csrf
         <div class="form-row">
           <div class="form-group col-md-6">
             <label for="">From:</label>
             <input type="date" class="form-control" name="from" autocomplete="off" required>
           </div>
           <div class="form-group col-md-6">
             <label for="">To:</label>
             <input type="date" class="form-control" name="to" autocomplete="off" required>
           </div>
           <div class="form-group col-md-12">
             <button type="submit" class="btn btn-success float-right"><i class="icon-copy dw dw-calendar1"></i> change-period</button>
           </div>
         </div>
       </form>
     </div>
   </div>
 </div>
