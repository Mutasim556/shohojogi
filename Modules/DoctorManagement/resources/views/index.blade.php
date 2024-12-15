@extends('backend.shared.layouts.admin')

@push('title')
    {{ __('admin_local.User List') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/custom.css') }}">
@endpush
@push('page_css')
    <style>
        .loader-box {
            height: auto;
            padding: 10px 0px;
        }

        .loader-box .loader-35:after {
            height: 20px;
            width: 10px;
        }

        .loader-box .loader-35:before {
            width: 20px;
            height: 10px;
        }
    </style>
@endpush

@section('content')
    <h1>Hello World</h1>

    <p>Module: {{ 'hello' }}</p>
@endsection

@push('js')
    <script src="{{ asset('public/admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/switchery/switchery.min.js') }}"></script>

    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        var oTable = $("#basic-1").DataTable({
            columnDefs: [{ width: 60, targets: 6 }],
        });

        var form_url = "{{ route('admin.user.store') }}";
    </script>
    <script src="{{ asset('public/admin/custom/user/create_user.js') }}"></script>
    <script src="{{ asset('public/admin/custom/user/user_list.js') }}"></script>
@endpush
