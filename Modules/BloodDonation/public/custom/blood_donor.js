

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
        success: function (data) {
            $('#edit_donor_form #donor_id').val(data.id);
            $('#edit_donor_form #donor_name').val(data.donor_name);
            $('#edit_donor_form #parent_donor').val(data.parent_donor_id);
            $('#edit_donor_form #parent_donor').trigger('change');
            if(data.donor_image==''){
                $('#edit_donor_form #image_preview').empty().append(no_file);
            }else{
                $('#edit_donor_form #image_preview').empty().append(`<img src="/${data.donor_image}">`);
            }
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


