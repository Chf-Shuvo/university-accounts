@extends('backend.layout.master')

@section('content')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
      <div class="pd-20 card-box height-100-p">
        <span>Current Period:From <b>{{ Carbon\Carbon::parse(Calculation::start_date())->format('d/m/Y') }} To
            {{ Carbon\Carbon::parse(Calculation::end_date())->format('d/m/Y') }}</b></span>
        <br>
        <span>Current Date: <b>{{ Carbon\Carbon::now()->format('d/m/Y') }}</b></span>
        <h4 class="p-2"><u>Company Details</u></h4>
        <table class="table table-borderless">
          <thead>
            <tr>
              <th>Name of The Company</th>
              <th>Last Date of Entry</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <h4>{{ auth()->user()->company_name }}</h4>
              </td>
              <td>
                <h4>{{ auth()->user()->company_last_entry_date }}</h4>
              </td>
            </tr>
          </tbody>
        </table>
        <h4 class="text-info text-center p-2">Gateway of {{ env('APP_NAME') }}</h4>
      </div>
    </div>
  </div>
@endsection
