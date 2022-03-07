<script src="{{ asset('backend/vendors/scripts/core.js') }}"></script>
<script src="{{ asset('backend/vendors/scripts/script.min.js') }}"></script>
<script src="{{ asset('backend/vendors/scripts/process.js') }}"></script>
<script src="{{ asset('backend/vendors/scripts/layout-settings.js') }}"></script>
@include('sweetalert::alert')
@stack('js')
