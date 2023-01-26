@extends('backend.layout.master')

@section('content')
  <div class="row mt-5">
    <div class="col-md-12 col-12">
      <div class="pd-20 card-box height-100-p">
        <h1 class="text-center">Balance Sheet</h1>
      </div>
    </div>
  </div>
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
            @php
              $liability_total = 0;
              $asset_total = 0;
            @endphp
            @foreach ($liability_items as $item)
              @php
                $liability_closing = $item->transaction_summary['openning'] + $item->transaction_summary['credit'] - $item->transaction_summary['debit'];
                $liability_total = $liability_total + $liability_closing;
              @endphp
              <tr>
                <td>
                  @if ($item->has_child > 0)
                    <a href="{{ route('report.balance-sheet.particurlars', [NameOfGroup::Liability->value, $item->id]) }}"><b>{{ $item->name }}</b></a>
                  @else
                    {{ $item->name }}
                  @endif
                </td>
                <td class="text-right">{{ $liability_closing }}</td>
              </tr>
            @endforeach
            @if ($difference > 0)
              <tr>
                <td><b>Excess of Income over Expenditure:</b></td>
                <td class="text-right">{{ $difference }}</td>
              </tr>
            @endif
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
                    <a href="{{ route('report.balance-sheet.particurlars', [NameOfGroup::Asset->value, $item->id]) }}"><b>{{ $item->name }}</b></a>
                  @else
                    {{ $item->name }}
                  @endif
                </td>
                <td class="text-right">{{ $item->transaction_summary['closing'] }}</td>
              </tr>
              @php
                $asset_total = $asset_total + $item->transaction_summary['closing'];
              @endphp
            @endforeach
            @if ($difference < 0)
              <tr>
                <td><b>Excess of Expenditure over Income:</b></td>
                <td class="text-right">{{ $difference }}</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-12 col-12 mt-2">
      <div class="pd-20 card-box height-100-p">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td><b>Total:</b></td>
              <td class="text-right">
                @if ($difference > 0)
                  {{ $liability_total + $difference }}
                @else
                  {{ $liability_total }}
                @endif
              </td>
              <td><b>Total:</b></td>
              <td class="text-right">
                @if ($difference < 0)
                  {{ $asset_total + $difference }}
                @else
                  {{ $asset_total }}
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
