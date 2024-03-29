@extends('backend.layout.master')

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/theme-default.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css">
@endpush

@section('content')
  @include('backend.partial.loading')
  <div class="row">
    <div class="{{ $ledgerHead->alias_of == null ? 'col-md-8' : 'col-md-12' }} col-12">
      <div class="pd-20 card-box height-100-p">
        <form action="{{ route('ledger-head.update', $ledgerHead->id) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
          <div class="form-row">
            <div class="form-group col-sm-12 col-md-4">
              <label for="">Ledger Head Code:</label>
              <input type="text" class="form-control" data-validation="required" name="head_code" value="{{ $ledgerHead->head_code }}">
            </div>
            <div class="form-group col-sm-12 col-md-4">
              <label for="">Ledger Head Name:</label>
              <input type="text" class="form-control" data-validation="required" name="name" value="{{ $ledgerHead->name }}">
              <small class="text-danger"><b>Don't use special characters like (~,#,$,/,\) in your LEDGER HEAD NAME.</b></small>
            </div>
            <div class="form-group col-sm-12 col-md-4">
              <label for="">Under:</label>
              <select name="parent_id" class="custom-select2 form-control" style="width: 100%;height:38px">
                <option value="0" @if ($ledgerHead->parent_id == 0) selected @endif>Primary</option>
                @foreach ($items as $item)
                  <option value="{{ $item->id }}" @if ($ledgerHead->parent_id == $item->id) selected @endif>
                    {{ $item->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-sm-12 col-md-6">
              <label for="">Visibility Order:</label>
              <input type="number" class="form-control" name="visibility_order" min="1" value="{{ $ledgerHead->visibility_order }}">
              <small class="text-danger font-weight-bold">Use this order if you are assigning this head under another head.</small>
            </div>
            <div class="form-group col-sm-12 col-md-6">
              <label for="">Name of Group:</label>
              <select name="name_of_group" class="form-control" style="width: 100%;height:40px;">
                <option value="{{ NameOfGroup::General->value }}" @if (NameOfGroup::General->value == $ledgerHead->name_of_group->value) selected @endif>{{ NameOfGroup::General->value }}</option>
                <option value="{{ NameOfGroup::Asset->value }}" @if (NameOfGroup::Asset->value == $ledgerHead->name_of_group->value) selected @endif>{{ NameOfGroup::Asset->value }}</option>
                <option value="{{ NameOfGroup::Liability->value }}" @if (NameOfGroup::Liability->value == $ledgerHead->name_of_group->value) selected @endif>{{ NameOfGroup::Liability->value }}</option>
                <option value="{{ NameOfGroup::Income->value }}" @if (NameOfGroup::Income->value == $ledgerHead->name_of_group->value) selected @endif>{{ NameOfGroup::Income->value }}</option>
                <option value="{{ NameOfGroup::Expense->value }}" @if (NameOfGroup::Expense->value == $ledgerHead->name_of_group->value) selected @endif>{{ NameOfGroup::Expense->value }}</option>
              </select>
              <small class="text-danger font-weight-bold">If this head is under Primary then select the Name of Group, otherwise keep it "General".</small>
            </div>
            <div class="form-group col-md-12 col-12">
              <button type="submit" class="btn btn-success btn-md float-right">submit</button>
            </div>
          </div>
        </form>
        @if ($ledgerHead->alias_of == null)
          {{-- create alias --}}
          <div class="form-group">
            <label for="">Create New Alias:</label>
            {{ csrf_field() }}
            <input type="text" name="alias_name" id="alias_name" class="form-control">
            <input type="hidden" name="alias_of" id="alias_of" value="{{ $ledgerHead->id }}">
            <small id="helpId" class="text-muted">Type name and hit the +alias button.</small>
            <button type="button" class="btn btn-success float-right mt-3" onclick="add_alias()"><i class="icon-copy dw dw-add"></i> alias</button>
          </div>
      </div>
      @endif
    </div>
    @if ($ledgerHead->alias_of == null)
      <div class="col-lg-4 col-md-4 col-12">
        <div class="pd-20 card-box height-100-p">
          <h5 class="py-2">Aliases</h5>
          <ul class="list-group" id="alias_list">
            @foreach ($ledgerHead->alias as $item)
              <li class="list-group-item">{{ $item->name }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif
  </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>
  <script>
    $(document).ready(function() {
      $.validate();
      $(".custom-select2").select2();
    });

    function add_alias() {
      let alias_name = $("#alias_name").val();
      let alias_of = $("#alias_of").val();
      if (alias_name.length == 0) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Cannot add empty data, check your input field.'
        })
      } else {
        $("#loading_screen").removeClass('d-none');
        let url = "{{ route('ledger-head.alias') }}";
        $.ajax({
          type: "post",
          url: url,
          data: {
            '_token': $("input[name='_token']").val(),
            'alias_name': $("#alias_name").val(),
            'alias_of': $("#alias_of").val()
          },
          dataType: "html",
          success: function(response) {
            $("#loading_screen").addClass('d-none');
            $("#alias_list").empty();
            $("#alias_list").html(response);
            $("#alias_name").val('');
            // success message
            Swal.fire({
              icon: 'success',
              title: 'Action Successful',
              text: 'Alias has been created successfully'
            })
          }
        });
      }
    }
  </script>
@endpush
