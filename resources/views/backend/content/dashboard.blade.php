@extends('backend.layout.master')

@section('content')
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <span>Current Period: <b>1 Jan 2022 - 31 Dec 2022</b></span>
            <br>
            <span>Current Date: <b>{{ Carbon\Carbon::now()->format('d M Y') }}</b></span>
        </div>
        <div class="col-md-12 col-12">
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
        </div>
    </div>
@endsection
