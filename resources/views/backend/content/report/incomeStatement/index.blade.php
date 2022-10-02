@extends('backend.layout.master')

@section('content')
  <div class="row mt-5">
    <div class="col-md-12 col-12">
      <div class="pd-20 card-box height-100-p">
        <h1 class="text-center">Income & Expense A/C</h1>
      </div>
    </div>
  </div>
  @include('backend.partial.date_setter')
  <div class="row mt-5">
    {{-- expense part --}}
    <div class="col-md-12">
      <div class="pd-20 card-box height-100-p">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-borderless">
              <thead class="border border-dark rounded">
                <tr>
                  <th>Expense</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $liability_total = 0;
                @endphp
                @foreach ($liability_items as $item)
                  <tr>
                    <td>
                      @if ($item->has_child > 0)
                        <a href="{{ route('report.expense.particurlars', $item->id) }}"><b>{{ $item->name }}</b></a>
                      @else
                        {{ $item->name }}
                      @endif
                    </td>
                    <td class="text-right">{{ $item->transaction_summary['closing'] }}</td>
                  </tr>
                  @php
                    $liability_total = $liability_total + $item->transaction_summary['closing'];
                  @endphp
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-borderless">
              <thead class="border border-dark rounded">
                <tr>
                  <th>Income</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $income_total = 0;
                @endphp
                @foreach ($asset_items as $item)
                  <tr>
                    <td>
                      @if ($item->has_child > 0)
                        <a href="{{ route('report.income.particurlars', $item->id) }}"><b>{{ $item->name }}</b></a>
                      @else
                        {{ $item->name }}
                      @endif
                    </td>
                    <td class="text-right">{{ -1 * $item->transaction_summary['closing'] }}</td>
                  </tr>
                  @php
                    $income_total = $income_total + -1 * $item->transaction_summary['closing'];
                  @endphp
                @endforeach
              </tbody>
            </table>
          </div>
          @php
            $difference = $income_total - $liability_total;
          @endphp
          <div class="col-md-6">
            @if ($difference > 0)
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td><b>Excess of Income over Expenditure:</b></td>
                    <td class="text-right">{{ $difference }}</td>
                  </tr>
                </tbody>
              </table>
            @endif
          </div>
          <div class="col-md-6">
            @if ($difference < 0)
              <table class="table-borderless">
                <tbody>
                  <tr>
                    <td><b>Excess of Expenditure over Income:</b></td>
                    <td class="text-right">{{ $difference }}</td>
                  </tr>
                </tbody>
              </table>
            @endif
          </div>
          <div class="col-md-12">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td><b>Total:</b></td>
                  <td class="text-right">
                    @if ($difference < 0)
                      {{ $liability_total }}
                    @else
                      {{ $liability_total + $difference }}
                    @endif
                  </td>
                  <td><b>Total:</b></td>
                  <td class="text-right">
                    @if ($difference > 0)
                      {{ $income_total }}
                    @else
                      {{ $income_total + $difference }}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
