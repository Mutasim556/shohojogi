

$(document).on('input', '#add_donor_form #name', function () {
    var donor_name = $(this).val().toUpperCase().replace('.', '').replace(/ /g, '_');
    $('#add_donor_form #username').val(donor_name);
})

$(document).on('input', '#add_donor_form #phone', function () {
    var donor_phone = $(this).val();
    $('#add_donor_form #password').val(donor_phone);
})

function getDivisionInfo(type, id, target) {
    $rr = $.ajax({
        type: 'GET',
        url: base_url + '/blood-donation/donor/get/division-information/' + type + '/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            var option = `<option value="">Select Please</option>`;
            $.each(data, function (key, val) {
                option = option + `<option value="${val.id}">${val.name}</option>`;
            })

            $(target).empty().append(option).trigger('change');
        },
        error: function () {

        }
    });

}

$(document).on('change', '#add_donor_form #division', function () {
    getDivisionInfo('district', $(this).val(), '#add_donor_form #district')
})

$(document).on('change', '#add_donor_form #district', function () {
    getDivisionInfo('upazila', $(this).val(), '#add_donor_form #upazila')
})


$(document).on('submit', '#add_donor_form', function (e) {
    e.preventDefault();
    $('#add_donor_form #submit_btn').html(submit_btn_after + '....');
    $('#add_donor_form #submit_btn').addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: form_url,
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (rdata) {
            $('button[type=submit]', '#add_donor_form').html(submit_btn_before);
            $('button[type=submit]', '#add_donor_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function () {
                let data = rdata.donor;
                let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if (rdata.hasEditPermission) {
                    update_status_btn = `<span class="mx-2">${data.user.status == 0 ? 'Inactive' : 'Active'}</span><input
                    data-status="${data.user.status == 0 ? 1 : 0}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" checked />`;
                }
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if (rdata.hasAnyPermission) {
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if (rdata.hasEditPermission) {
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-donor-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if (rdata.hasDeletePermission) {
                        action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }


                let donor_image = data.user.image ? '<img src="'+base_url+'/'+data.user.image +'" height="100px"/>' : no_file;
                $('#basic-1 tbody').append(`<tr id="trid-${data.id}" data-id="${data.id}"><td>${data.user.name}</td><td>${donor_image}</td><td>${data.user.phone}</td><td>${data.user.username}</td><td>${data.district.name}</td><td>${data.upazila.name}</td><td>${data.blood_group}</td><td>${data.last_donation_date}</td><td>${data.next_donation_date}</td>
                <td class="text-center">${update_status_btn}</td>
                <td>${action_option}</td></tr>`);

                new Switchery($('#trid-' + data.id).find('input')[0], $('#trid-' + data.id).find('input').data());

                $('#add_donor_form .err-mgs').each(function (id, val) {
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_donor_form').trigger('reset');
                $('button[type=button]', '#add_donor_form').click();
            })
        },
        error: function (err) {
            $('button[type=submit]', '#add_donor_form').html(submit_btn_before);
            $('button[type=submit]', '#add_donor_form').removeClass('disabled');
            if (err.status === 403) {
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function () {
                    $('button[type=button]', '##add_donor_form').click();
                });

            }

            $('#add_donor_form .err-mgs').each(function (id, val) {
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id', '')
                $(this).empty();
            })
            $.each(err.responseJSON.errors, function (idx, val) {
                // console.log('#add_donor_form #'+idx);
                var exp = idx.replace('.', '_');
                $('#add_donor_form #' + exp).addClass('border-danger is-invalid')
                $('#add_donor_form #' + exp).next('span').find('.select2-selection--single').attr('id', 'invalid-selec2')
                $('#add_donor_form #' + exp).next('.err-mgs').empty().append(val);

                $('#add_donor_form #' + exp + "_err").empty().append(val);
            })
        }
    })
});

//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'donor/status/update',
        data : {'id':update_id,'status':status},
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input data-status="${data.status==1?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.status==1?'checked':''} />`);
            // parent_td.children('input').each(function (idx, obj) {
            //     new Switchery($(this)[0], $(this).data());
            // });
            new Switchery(cat_td.find('input')[0], cat_td.find('input').data());
        },
        error: function (err) {
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    });
});


// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_donor_form').trigger('reset');
    $('#edit_donor_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let donor = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'donor/' + donor + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (rdata) {
            // console.log(data.address);
            var data = rdata.data;
            $('#edit_donor_form #donor_id').val(data.donor_id);
            $('#edit_donor_form #user_id').val(data.user_id);
            $('#edit_donor_form #tr_id').val("trid-"+donor);
            $('#edit_donor_form #name').val(data.donor_name);
            $('#edit_donor_form #username').val(data.username);
            $('#edit_donor_form #division').val(data.division).trigger('change');
            var option = `<option value="">Select Please</option>`;
            $.each(data.districts,function(key,val){
                option = option + `<option value="${val.id}">${val.name}</option>`;
            });
            $('#edit_donor_form #district').empty().append(option).val(data.district).trigger('change');

            option = `<option value="">Select Please</option>`;
            $.each(data.upazilas,function(key,val){
                option = option + `<option value="${val.id}">${val.name}</option>`;
            });
            $('#edit_donor_form #upazila').empty().append(option).val(data.upazila).trigger('change');

            $('#edit_donor_form #address').val(data.address);
            $('#edit_donor_form #phone').val(data.phone);
            $('#edit_donor_form #email').val(data.email);
            $('#edit_donor_form #dob').val(data.dob);
            $('#edit_donor_form #blood_group').val(data.blood_group).trigger('change');
            $('#edit_donor_form #last_donation_date').val(data.last_donation_date);
            $('#edit_donor_form #is_active').removeAttr('checked').attr('checked',data.is_active==0?false:true);
            $('#edit_donor_form #is_tmp_password').removeAttr('checked').attr('checked',data.is_tmp_password==0?false:true);
            $('#edit_donor_form #last_donation_details').val(data.donation_details);
        },
        error: function (err) {
            if(err.status===403){
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_donor_form').click();
                });
                
            }else{
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                });
            }
        }
    });

});

$(document).on('submit','#edit_donor_form',function(e){
    e.preventDefault();
    $('#edit_donor_form #submit_btn').html(submit_btn_after+'....');
    $('#edit_donor_form #submit_btn').addClass('disabled');
    var trid = '#'+$('#tr_id', this).val();
    var formData = new FormData(this);

    $.ajax({
        type: "POST",
        url: 'donor/'+$('#edit_donor_form #donor_id').val(),
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#edit_donor_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_donor_form').removeClass('disabled');
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function(){
                $('button[type=submit]', '#edit_donor_form').html(submit_btn_before);
                $('button[type=submit]', '#edit_donor_form').removeClass('disabled');
                $('td:nth-child(1)',trid).html(data.donor.donor_name);
                let donor_image = data.donor.donor_image ? '<img src="'+base_url+'/'+data.donor.donor_image +'" height="100px"/>' : no_file;
                $('td:nth-child(2)',trid).empty().append(donor_image);
                $('td:nth-child(3)',trid).html(data.donor.phone);
                $('td:nth-child(4)',trid).html(data.donor.username);
                $('td:nth-child(5)',trid).html(data.donor.district_name);
                $('td:nth-child(6)',trid).html(data.donor.upazila_name);
                $('td:nth-child(7)',trid).html(data.donor.blood_group);
                $('td:nth-child(8)',trid).html(data.donor.last_donation_date);
                $('td:nth-child(9)',trid).html(data.donor.next_donation_date);

                $('button[type=button]', '#edit_donor_form').click();
            })
        },
        error: function (err) {
            $('button[type=submit]', '#edit_donor_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_donor_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_donor_form').click();
                });

            }

            $('#edit_donor_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#edit_donor_form #'+idx);
                var exp = idx.replace('.','_');
                $('#edit_donor_form #'+exp).addClass('border-danger is-invalid')
                $('#edit_donor_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#edit_donor_form #'+exp).next('.err-mgs').empty().append(val);

                $('#edit_donor_form #'+exp+"_err").empty().append(val);
            })
        }
    })
});
//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: delete_swal_title,
        text: delete_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'donor/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        $('#trid-'+delete_id).hide();
                    });
                },
                error: function (err) {
                    var err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    });
                }
            });
           
        } else {
            swal(delete_swal_cancel_text);
        }
    })
});
