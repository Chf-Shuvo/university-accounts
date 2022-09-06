@extends('backend.layout.master')

@section('content')
  @include('backend.partial.date_setter')
  <div class="row mt-5">
    <div class="col-md-6 col-12">
      <div class="pd-20 card-box height-100-p">
        <table class="table table-borderless">
          <thead class="border border-dark rounded">
            <tr>
              <th>Liability</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($liability_items as $item)
              <tr>
                <td>
                  @if ($item->has_child > 0)
                    <a href="{{ route('report.balance-sheet.particurlars', $item->id) }}"><b>{{ $item->name }}</b></a>
                  @else
                    {{ $item->name }}
                  @endif
                </td>
                <td class="text-right">{{ $item->transaction_summary['closing'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="pd-20 card-box height-100-p">
        <table class="table table-borderless">
          <thead class="border border-dark rounded">
            <tr>
              <th>Asset</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($asset_items as $item)
              <tr>
                <td>
                  @if ($item->has_child > 0)
                    <a href="{{ route('report.balance-sheet.particurlars', $item->id) }}"><b>{{ $item->name }}</b></a>
                  @else
                    {{ $item->name }}
                  @endif
                </td>
                <td class="text-right">{{ $item->transaction_summary['closing'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
