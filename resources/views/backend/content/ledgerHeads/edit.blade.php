@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
@endpush

@section('content')
  <div class="row">
    <div class="col-md-12 col-12">
      <form action="{{ route('ledger-head.update', $ledgerHead->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method("PATCH")
        <div class="form-row">
          <div class="form-group col-md-6 col-12">
            <label for="">Ledger Head Code:</label>
            <input type="text" class="form-control" data-validation="number" name="head_code" value="{{ $ledgerHead->head_code }}">
          </div>
          <div class="form-group col-md-6 col-12">
            <label for="">Ledger Head Name:</label>
            <input type="text" class="form-control" data-validation="required" name="name" value="{{ $ledgerHead->name }}">
          </div>
          <div class="form-group col-md-12 col-12">
            <label for="">Under:</label>
            <select name="parent_id" class="custom-select2 form-control" style="width: 100%;height:38px">
              <option value="0" @if ($ledgerHead->parent_id == 0) selected @endif>Primary</option>
              @foreach ($items as $item)
                <option value="{{ $item->id }}" @if ($ledgerHead->parent_id == $item->id) selected @endif>
                  {{ $item->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-12 col-12">
            <button type="submit" class="btn btn-success btn-md float-right">submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
  <script>
    $(document).ready(function() {
      $.validate();
      $(".custom-select2").select2();
    });
  </script>
@endpush
