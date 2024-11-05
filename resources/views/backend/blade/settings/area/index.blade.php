@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Area List') }}
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
    {{-- <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.area List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.area') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.area List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Add area Modal Start --}}

    <div class="modal fade" id="add-area-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Area') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="add_area_form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 mt-2">
                                <label for="area_role"><strong>{{ __('admin_local.Area Type') }} *</strong></label>
                                <select class="js-example-basic-single"  name="area_type" id="area_type">
                                    <option value="" selected disabled>{{ __("admin_local.Select Please") }}</option>
                                    <option value="Division">{{ __('admin_local.Division') }}</option>
                                    <option value="District">{{ __('admin_local.District') }}</option>
                                    <option value="Upazila">{{ __('admin_local.Upazila') }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="area_type_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2" id="division_div">
                                <label for="area_role"><strong>{{ __('admin_local.Division') }} *</strong></label>
                                <select class="js-example-basic-single"  name="division" id="division">
                                    <option value="" selected disabled>{{ __("admin_local.Select Please") }}</option>
                                    @foreach ($areas as $area)
                                       <option value="{{ $area->id }}">{{ $area->name }}</option> 
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="division_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2" id="district_div">
                                <label for="area_role"><strong>{{ __('admin_local.District') }} *</strong></label>
                                <select class="js-example-basic-single"  name="district" id="district">
                                    <option value="" selected disabled>{{ __("admin_local.Select Please") }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="district_err"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-2">
                                <label for="name_english"><strong>{{ __('admin_local.Name (English)') }} *</strong></label>
                                <input type="text" class="form-control" name="name_english" id="name_english">
                                <span class="text-danger err-mgs" id="name_english_err"></span>
                            </div>

                            <div class="col-lg-4 mt-2">
                                <label for="name_bangla"><strong>{{ __('admin_local.Name (Bangla)') }} *</strong></label>
                                <input type="text" class="form-control" name="name_bangla" id="name_bangla">
                                <span class="text-danger err-mgs" id="name_bangla_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="name_bangla"><strong>{{ __('admin_local.Area Code') }} *</strong></label>
                                <input type="text" class="form-control" name="area_code" id="area_code">
                                <span class="text-danger err-mgs" id="area_code_err"></span>
                            </div>
                        </div>
                        
                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('admin_local.Submit') }}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add area Modal End --}}

    {{-- Edit area Modal Start --}}

    <div class="modal fade" id="edit-area-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit area') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="edit_area_form">
                        @csrf
                        <input type="hidden" id="area_id" name="area_id" value="">
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="area_name"><strong>{{ __('admin_local.Full Name') }} *</strong></label>
                                <input type="text" class="form-control" name="area_name" id="area_name">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="areaname"><strong>{{ __('admin_local.areaname') }} *</strong></label>
                                <input type="text" class="form-control" name="areaname" id="areaname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="area_password"><strong>{{ __('admin_local.Password') }} *</strong></label>
                                <input type="password" class="form-control" name="area_password" id="area_password">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="area_role"><strong>{{ __('admin_local.Role') }} *</strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="area_email"><strong>{{ __('admin_local.Email') }} *</strong></label>
                                <input type="email" class="form-control" name="area_email" id="area_email">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="area_phone"><strong>{{ __('admin_local.Phone') }} *</strong></label>
                                <input type="text" class="form-control" name="area_phone" id="area_phone">
                            </div>
                        </div>
                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('admin_local.Submit') }}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit area Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-11 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.area List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['area-create']))
                            <div class="row mb-3">
                                <div class="col-md-3 mt-2">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-area-modal">+ {{ __('admin_local.Add Area') }}</button>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <select class="js-example-basic-single2" id="view_area_type">
                                        <option value="division" selected>{{ __('admin_local.Division') }}</option>
                                        <option value="district">{{ __('admin_local.District') }}</option>
                                        <option value="upazila">{{ __('admin_local.Upazila') }}</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive theme-scrollbar" id="append_area_data">
                            <div class="col-12 text-center my-3" id="loader" style="display:none">
                                <div class="loader-box">
                                    <h5 class="mt-2">{{ __('admin_local.Please wait') }}</h5><div class="loader-15 mx-3"></div>
                                  </div>
                            </div>
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Name(English)') }}</th>
                                        <th>{{ __('admin_local.Name(Bangla)') }}</th>
                                        <th>{{ __('admin_local.Area Code') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($areas as $area)
                                        <tr id="tr-{{ $area->id }}" data-id="{{ $area->id }}">
                                            <td>{{ $area->name }}</td>
                                            <td>{{ $area->bn_name }}</td>
                                            <td>{{ $area->area_code?$area->area_code:__('admin_local.Not Updated') }}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['area-update']))
                                                    <span class="mx-2">{{ $area->status==1?'Active':'Inactive' }}</span><input
                                                    data-status="{{ $area->status == 1 ? 0 : 1 }}"
                                                    id="status_change" type="checkbox" data-toggle="switchery"
                                                    data-color="green" data-secondary-color="red" data-size="small"
                                                    {{ $area->status == 1 ? 'checked' : '' }}/>
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (hasPermission(['area-update','area-delete']))
                                                    <div class="dropdown ">
                                                        <button
                                                            class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                            <i class="fa fa-angle-down"></i></button>
                                                        <div class="dropdown-content">
                                                            @if (hasPermission(['area-update']))
                                                                <a data-bs-toggle="modal" style="cursor: pointer;"
                                                                    data-bs-target="#edit-area-modal" class="text-primary"
                                                                    id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                            @endif
                                                            @if (hasPermission(['area-delete']))
                                                                <a class="text-danger" id="delete_button"
                                                                style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                                                {{ __('admin_local.Delete') }}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            @csrf
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->
    </div>
@endsection
@push('js')
    <script src="{{ asset('public/admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/switchery/switchery.min.js') }}"></script>

    <script src="{{ asset('public/admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-area-modal')
        });
        $('.js-example-basic-single2').select2();

        var oTable = $("#basic-1").DataTable();

        var add_form_url = "{{ route('admin.settings.area.store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;
    </script>
    <script src="{{ asset('public/admin/custom/area/create_area.js') }}"></script>
    <script src="{{ asset('public/admin/custom/area/area_list.js') }}"></script> 
@endpush
