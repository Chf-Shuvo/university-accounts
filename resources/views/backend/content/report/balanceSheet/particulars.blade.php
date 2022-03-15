@extends('backend.layout.master')

@push('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
@endpush

@section('content')
    <div class="row mt-5">
        <div class="col-md-12 col-12">
            <table class="data-table-export table table-striped">
                <thead>
                    <tr>
                        <th colspan="2"></th>
                        <th class="text-center">{{ $particular->name }} <br>
                            {{ auth()->user()->company_name }} <br> Time Frame
                            <br>Closing Balance
                        </th>
                    </tr>
                    <tr>
                        <th>Particulars</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($particular->particulars as $item)
                        <tr>
                            <td>
                                @if ($item->has_child > 0)
                                    <a
                                        href="{{ route('report.balance-sheet.particurlars', $item->id) }}"><b>{{ $item->name }}</b></a>
                                @else
                                    <a
                                        href="{{ route('report.balance-sheet.transactions', $item->id) }}"><b>{{ $item->name }}</b></a>
                                @endif
                            </td>
                            <td class="text-right">{{ $item->debit }}</td>
                            <td class="text-right">{{ $item->credit }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- buttons for Export datatable -->
    <script src="{{ asset('backend/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/datatables/js/vfs_fonts.js') }}"></script>
    <!-- Datatable Setting js -->
    <script src="{{ asset('backend/vendors/scripts/datatable-setting.js') }}"></script>
    </body>
@endpush
