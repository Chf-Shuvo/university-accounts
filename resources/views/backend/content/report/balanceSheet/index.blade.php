@extends('backend.layout.master')

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <table class="table table-borderless">
                <thead class="border border-dark rounded">
                    <tr>
                        <th>Liabilities</th>
                        <th class="text-right">BAIUST <span>as at 1 July 2022</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($liability_items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td class="text-right">0</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6 col-12">
            <table class="table table-borderless">
                <thead class="border border-dark rounded">
                    <tr>
                        <th>Assets</th>
                        <th class="text-right">BAIUST <span>as at 1 July 2022</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asset_items as $item)
                        <tr>
                            <td>
                                @if ($item->has_child > 0)
                                    <a
                                        href="{{ route('report.balance-sheet.particurlars', $item->id) }}"><b>{{ $item->name }}</b></a>
                                @else
                                    {{ $item->name }}
                                @endif
                            </td>
                            <td class="text-right">0</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
