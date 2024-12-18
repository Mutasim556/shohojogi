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
    {{-- <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.User List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.User') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.User List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="add-donor-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Blood Donor') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger">
                    <i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="add_donor_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="user_name"><strong>{{ __('admin_local.Donor Full Name') }} *</strong></label>
                                <input type="text" class="form-control" name="name" id="name">
                                <span class="text-danger err-mgs" id="name_err"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="username"><strong>{{ __('admin_local.Donor User Name') }} *</strong></label>
                                <input type="text" class="form-control" name="username" id="username">
                                <span class="text-danger err-mgs" id="username_err"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Division') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="division" id="division">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ $division->name == 'Rangpur' ? 'selected' : '' }}>
                                            {{ $division->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="division_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.District') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="district" id="district">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">
                                            {{ $district->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="district_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Upazila') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="upazila" id="upazila">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="upazila_err"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Address') }} </strong></label>
                                <textarea class="form-control" name="address" id="address"></textarea>
                                <span class="text-danger err-mgs" id="address_err"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Donor Phone') }} *</strong></label>
                                <input type="text" class="form-control" name="phone" id="phone">
                                <span class="text-danger err-mgs" id="phone_err"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Donor Email') }} </strong></label>
                                <input type="email" class="form-control" name="email" id="email">
                                <span class="text-danger err-mgs" id="email_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Donor Date Of Birth') }}
                                        *</strong></label>
                                <input type="date" class="form-control" name="dob" id="dob">
                                <span class="text-danger err-mgs" id="dob_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Blood Group') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="blood_group" id="blood_group">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="A+">A+ (Positive)</option>
                                    <option value="B+">B+ (Positive)</option>
                                    <option value="AB+">AB+ (Positive)</option>
                                    <option value="O+">O+ (Positive)</option>
                                    <option value="A-">A- (Negative)</option>
                                    <option value="B-">B- (Negative)</option>
                                    <option value="AB-">AB- (Negative)</option>
                                    <option value="O-">O- (Negative)</option>
                                </select>
                                <span class="text-danger err-mgs" id="blood_group_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Last Donation Date') }}
                                    </strong></label>
                                <input type="date" class="form-control" name="last_donation_date"
                                    id="last_donation_date">
                                <span class="text-danger err-mgs" id="last_donation_date_err"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Is Active') }} </strong></label><br>
                                <input type="checkbox" name="is_active" id="is_active" checked>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Is TMP Password') }}
                                    </strong></label><br>
                                <input type="checkbox" name="is_tmp_password" id="is_tmp_password" checked>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="user_password"><strong>{{ __('admin_local.Password') }} *</strong></label>
                                <input type="password" class="form-control" name="password" id="password">
                                <span class="text-danger err-mgs" id="password_err"></span>
                            </div>
                            <div class="col-lg-8 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Last Donation Details') }}
                                    </strong></label>
                                <textarea class="form-control" name="last_donation_details" id="last_donation_details"></textarea>
                                <span class="text-danger err-mgs" id="last_donation_details_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="donor_image"><strong>{{ __('admin_local.Donor Image') }} </strong></label>
                                <input type="file" class="form-control" name="donor_image" id="donor_image">
                                <span class="text-danger err-mgs" id="donor_image_err"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button id="submit_btn" class="btn btn-primary mx-2" style="float: right"
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

    {{-- Add User Modal End --}}

    {{-- Edit User Modal Start --}}

    <div class="modal fade" id="edit-donor-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Donor') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger">
                    <i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="edit_donor_form">
                        @csrf
                        <input type="hidden" id="donor_id" name="donor_id" value="">
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="user_name"><strong>{{ __('admin_local.Donor Full Name') }} *</strong></label>
                                <input type="text" class="form-control" name="name" id="name">
                                <span class="text-danger err-mgs" id="name_err"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="username"><strong>{{ __('admin_local.Donor User Name') }} *</strong></label>
                                <input type="text" class="form-control" name="username" id="username">
                                <span class="text-danger err-mgs" id="username_err"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Division') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="division" id="division">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ $division->name == 'Rangpur' ? 'selected' : '' }}>
                                            {{ $division->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="division_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.District') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="district" id="district">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">
                                            {{ $district->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="district_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Upazila') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="upazila" id="upazila">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="upazila_err"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Address') }} </strong></label>
                                <textarea class="form-control" name="address" id="address"></textarea>
                                <span class="text-danger err-mgs" id="address_err"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Donor Phone') }} *</strong></label>
                                <input type="text" class="form-control" name="phone" id="phone">
                                <span class="text-danger err-mgs" id="phone_err"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Donor Email') }} </strong></label>
                                <input type="email" class="form-control" name="email" id="email">
                                <span class="text-danger err-mgs" id="email_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Donor Date Of Birth') }}
                                        *</strong></label>
                                <input type="date" class="form-control" name="dob" id="dob">
                                <span class="text-danger err-mgs" id="dob_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Blood Group') }} *</strong></label>
                                <select class="form-control js-example-basic-single" name="blood_group" id="blood_group">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="A+">A+ (Positive)</option>
                                    <option value="B+">B+ (Positive)</option>
                                    <option value="AB+">AB+ (Positive)</option>
                                    <option value="O+">O+ (Positive)</option>
                                    <option value="A-">A- (Negative)</option>
                                    <option value="B-">B- (Negative)</option>
                                    <option value="AB-">AB- (Negative)</option>
                                    <option value="O-">O- (Negative)</option>
                                </select>
                                <span class="text-danger err-mgs" id="blood_group_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Last Donation Date') }}
                                    </strong></label>
                                <input type="date" class="form-control" name="last_donation_date"
                                    id="last_donation_date">
                                <span class="text-danger err-mgs" id="last_donation_date_err"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Is Active') }} </strong></label><br>
                                <input type="checkbox" name="is_active" id="is_active" checked>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="user_email"><strong>{{ __('admin_local.Is TMP Password') }}
                                    </strong></label><br>
                                <input type="checkbox" name="is_tmp_password" id="is_tmp_password" checked>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="user_password"><strong>{{ __('admin_local.Password') }} *</strong></label>
                                <input type="password" class="form-control" name="password" id="password">
                                <span class="text-danger err-mgs" id="password_err"></span>
                            </div>
                            <div class="col-lg-8 mt-2">
                                <label for="user_phone"><strong>{{ __('admin_local.Last Donation Details') }}
                                    </strong></label>
                                <textarea class="form-control" name="last_donation_details" id="last_donation_details"></textarea>
                                <span class="text-danger err-mgs" id="last_donation_details_err"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="donor_image"><strong>{{ __('admin_local.Donor Image') }} </strong></label>
                                <input type="file" class="form-control" name="donor_image" id="donor_image">
                                <span class="text-danger err-mgs" id="donor_image_err"></span>
                            </div>
                        </div>
                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">
                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button id="submit_btn" class="btn btn-primary mx-2" style="float: right"
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

    {{-- Edit User Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-11 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Blood Donor List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['blood-donor-create']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-donor-modal">+
                                        {{ __('admin_local.Add Blood Donor') }}</button>
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Full Name') }}</th>
                                        <th>{{ __('admin_local.Image') }}</th>
                                        <th>{{ __('admin_local.Phone') }}</th>
                                        <th>{{ __('admin_local.User Name') }}</th>
                                        <th>{{ __('admin_local.District') }}</th>
                                        <th>{{ __('admin_local.Upazila') }}</th>
                                        <th>{{ __('admin_local.Blood Group') }}</th>
                                        <th>{{ __('admin_local.Last Donation Date') }}</th>
                                        <th>{{ __('admin_local.Next Donation Date') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donors as $donor)
                                        <tr id="tr-{{ $donor->id }}" data-id="{{ $donor->id }}">
                                            <td>{{ $donor->user->name }}</td>
                                            <td>{!! $donor->user->image ? '<img src="'.asset($donor->user->image).'" height="100px"/>' : 'No File' !!}</td>
                                            <td>{{ $donor->user->phone }}</td>
                                            <td>{{ $donor->user->username }}</td>
                                            <td>{{ $donor->district->name }}</td>
                                            <td>{{ $donor->upazila->name }}</td>
                                            <td>{{ $donor->blood_group }}</td>
                                            <td>{{ $donor->last_donation_date }}</td>
                                            <td>{{ $donor->next_donation_date }}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['blood-donor-update']))
                                                    <span
                                                        class="mx-2">{{ $donor->user->status == 1 ? 'Active' : 'Inactive' }}</span><input
                                                        data-status="{{ $donor->user->status == 1 ? 0 : 1 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $donor->user->status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span
                                                        class="badge badge-danger">{{ __('admin_loacl.No Permission') }}</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if (hasPermission(['blood-donor-update', 'blood-donor-delete']))
                                                    <div class="dropdown ">
                                                        <button
                                                            class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                            <i class="fa fa-angle-down"></i></button>
                                                        <div class="dropdown-content">
                                                            @if (hasPermission(['blood-donor-update']))
                                                                <a data-bs-toggle="modal" style="cursor: pointer;"
                                                                    data-bs-target="#edit-donor-modal"
                                                                    class="text-primary" id="edit_button"><i
                                                                        class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                            @endif
                                                            @if (hasPermission(['blood-donor-delete']))
                                                                <a class="text-danger" id="delete_button"
                                                                    style="cursor: pointer;"><i
                                                                        class="fa fa-trash mx-1"></i>
                                                                    {{ __('admin_local.Delete') }}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span
                                                        class="badge badge-danger">{{ __('admin_loacl.No Permission') }}</span>
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
        var oTable = $("#basic-1").DataTable({
            columnDefs: [{ width: 100, targets: 10 },{ width: 100, targets: 9 }],
        });

        $('.js-example-basic-single').each(function() {
            $(this).select2({
                dropdownParent: $('#add-donor-modal')
            })
            $(this).select2({
                dropdownParent: $('#edit-donor-modal')
            })
        })
        var base_url = `{{ URL::to('/') }}`;
        var form_url = "{{ route('blood_donation.donor.store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;
        var download_icon = `{{ __('admin_local.Icon') }}`;
        var download_title = `{{ __('admin_local.Title') }}`;
        var no_file = `{{ __('admin_local.No File') }}`;
        var download_remove = `{{ __('admin_local.Remove') }}`;
    </script>
    <script src="{{ asset(bld_asset() . 'custom/blood_donor.js') }}"></script>
@endpush
