$(document).on('change','#add_area_form #area_type',function(){
    if($(this).val()=='Division'){
        $('#add_area_form #division_div').hide(500);
        $('#add_area_form #district_div').hide(500);
    }else if($(this).val()=='District'){
        $('#add_area_form #division_div').show(500);
        $('#add_area_form #district_div').hide(500);
    }else{
        $('#add_area_form #division_div').show(500);
        $('#add_area_form #district_div').show(500);
    }
})
$(document).on('change','#add_area_form #division_div',function(){
    var id = $('#division').val();
    if($('#area_type').val()=='Upazila'){
        $.ajax({
            type: "GET",
            url: 'area/'+id,
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
               var options = `<option value="" selected disabled>Select Please</option>`;
               $.each(data,function(key,val){
                    options = options + `<option value="${val.id}">${val.name}</option>`
               })

               $('#district').empty().append(options).trigger('change');
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
        })
    }
    
})
$(document).on('submit','#add_area_form',function(e){
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: add_form_url,
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#add_area_form').html(submit_btn_before);
            $('button[type=submit]', '#add_area_form').removeClass('disabled');
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function(){
                if(data.area_type=='division' && data.area_type==$('#view_area_type').val()){
                    var rowData = data.area;
                    let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                    if(data.hasEditPermission){
                        update_status_btn = `<span class="mx-2">${rowData.status==0?'Inactive':'Active'}</span><input
                        data-status="${rowData.status==0?1:0}"
                        id="status_change" type="checkbox" data-toggle="switchery"
                        data-color="green" data-secondary-color="red" data-size="small" checked />`;
                    }
                    let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                    if(data.hasAnyPermission){
                        action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                        if(data.hasEditPermission){
                            action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-parent-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                        }
                        if(data.hasDeletePermission){
                            action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                        }
    
                        action_option = action_option + `</div></div>`;
                    }
                    $('#basic-1 tbody').append(`<tr id="trid-${rowData.id}" data-id="${rowData.id}"><td>${rowData.name}</td><td>${rowData.bn_name}</td><td>${rowData.area_code?rowData.area_code:'N/A'}</td>
                    <td class="text-center">${update_status_btn}</td>
                    <td>${action_option}</td></tr>`);
                    if(data.hasEditPermission){
                        new Switchery($('#trid-'+rowData.id).find('input')[0], $('#trid-'+rowData.id).find('input').data());
                    }
                }else if(data.area_type=='district' && data.area_type==$('#view_area_type').val()){
                    var rowData = data.area;
                    let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                    if(data.hasEditPermission){
                        update_status_btn = `<span class="mx-2">${rowData.status==0?'Inactive':'Active'}</span><input
                        data-status="${rowData.status==0?1:0}"
                        id="status_change" type="checkbox" data-toggle="switchery"
                        data-color="green" data-secondary-color="red" data-size="small" checked />`;
                    }
                    let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                    if(data.hasAnyPermission){
                        action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                        if(data.hasEditPermission){
                            action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-parent-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                        }
                        if(data.hasDeletePermission){
                            action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                        }

                        action_option = action_option + `</div></div>`;
                    }
                    $('#basic-1 tbody').append(`<tr id="trid-${rowData.id}" data-id="${rowData.id}"><td>${rowData.name}</td><td>${rowData.bn_name}</td><td>${rowData.division_name}</td><td>${rowData.area_code?rowData.area_code:'N/A'}</td>
                    <td class="text-center">${update_status_btn}</td>
                    <td>${action_option}</td></tr>`);
                    if(data.hasEditPermission){
                        new Switchery($('#trid-'+rowData.id).find('input')[0], $('#trid-'+rowData.id).find('input').data());
                    }
                }else if(data.area_type=='upazila' && data.area_type==$('#view_area_type').val()){
                    var rowData = data.area;
                    let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                    if(data.hasEditPermission){
                        update_status_btn = `<span class="mx-2">${rowData.status==0?'Inactive':'Active'}</span><input
                        data-status="${rowData.status==0?1:0}"
                        id="status_change" type="checkbox" data-toggle="switchery"
                        data-color="green" data-secondary-color="red" data-size="small" checked />`;
                    }
                    let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                    if(data.hasAnyPermission){
                        action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                        if(data.hasEditPermission){
                            action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-parent-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                        }
                        if(data.hasDeletePermission){
                            action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                        }
    
                        action_option = action_option + `</div></div>`;
                    }
                    $('#basic-1 tbody').append(`<tr id="trid-${rowData.id}" data-id="${rowData.id}"><td>${rowData.name}</td><td>${rowData.bn_name}</td><td>${rowData.division_name}</td><td>${rowData.district_name}</td><td>${rowData.area_code?rowData.area_code:'N/A'}</td>
                    <td class="text-center">${update_status_btn}</td>
                    <td>${action_option}</td></tr>`);
                    if(data.hasEditPermission){
                        new Switchery($('#trid-'+rowData.id).find('input')[0], $('#trid-'+rowData.id).find('input').data());
                    }
                }
                

                $('#add_area_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_area_form').trigger('reset');
                $('button[type=button]','#add_area_form').click();
            })
        },
        error: function (err) {
            $('button[type=submit]', '#add_area_form').html(submit_btn_before);
            $('button[type=submit]', '#add_area_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_area_form').click();
                });
                
            }

            $('#add_area_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#add_area_form #'+idx);
                var exp = idx.replace('.','_');
                $('#add_area_form #'+exp).addClass('border-danger is-invalid')
                $('#add_area_form #'+exp).addClass('border-danger is-invalid')
                $('#add_area_form #'+exp).next('.err-mgs').empty().append(val);
           
                $('#add_area_form #'+exp+"_err").empty().append(val);
            })
        }
    })


})

$(document).on('change','#view_area_type',function(){
    $('#loader').show();
    $('#basic-1').hide();
    $('#basic-1').DataTable().destroy();
    $.ajax({
        type: "GET",
        url: 'area/get-area-data/'+$(this).val(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            
            $('#basic-1').hide();
            $('#loader').hide();
            if(data.area_type=='division'){
                    $('#basic-1 thead tr').empty().append(`<th>Name(English)</th><th>Name(Bangla)</th><th>Area Code</th><th>Status</th><th>Action</th>`)
                
                    $('#basic-1 tbody').empty();
                    $('#basic-1').show();
                    $.each(data.area,function(key,rowData){
                        let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                        if(data.hasEditPermission){
                            update_status_btn = `<span class="mx-2">${rowData.status==0?'Inactive':'Active'}</span><input
                            data-status="${rowData.status==0?1:0}"
                            id="status_change" type="checkbox" data-toggle="switchery"
                            data-color="green" data-secondary-color="red" data-size="small" checked />`;
                        }
                        let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                        if(data.hasAnyPermission){
                            action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                            if(data.hasEditPermission){
                                action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-parent-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                            }
                            if(data.hasDeletePermission){
                                action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                            }

                            action_option = action_option + `</div></div>`;
                        }
                        $('#basic-1 tbody').append(`<tr id="trid-${rowData.id}" data-id="${rowData.id}"><td>${rowData.name}</td><td>${rowData.bn_name}</td><td>${rowData.area_code?rowData.area_code:'N/A'}</td>
                        <td class="text-center">${update_status_btn}</td>
                        <td>${action_option}</td></tr>`);
                        if(data.hasEditPermission){
                            new Switchery($('#trid-'+rowData.id).find('input')[0], $('#trid-'+rowData.id).find('input').data());
                        }
                    })
                    $('#basic-1').DataTable()
            }else if(data.area_type=='district'){
                $('#basic-1 thead tr').empty().append(`<th>Name(English)</th><th>Name(Bangla)</th><th>Division</th><th>Area Code</th><th>Status</th><th>Action</th>`)
                
                $('#basic-1 tbody').empty();
                $('#basic-1').show();
                $.each(data.area,function(key,rowData){
                    let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                    if(data.hasEditPermission){
                        update_status_btn = `<span class="mx-2">${rowData.status==0?'Inactive':'Active'}</span><input
                        data-status="${rowData.status==0?1:0}"
                        id="status_change" type="checkbox" data-toggle="switchery"
                        data-color="green" data-secondary-color="red" data-size="small" checked />`;
                    }
                    let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                    if(data.hasAnyPermission){
                        action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                        if(data.hasEditPermission){
                            action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-parent-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                        }
                        if(data.hasDeletePermission){
                            action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                        }
    
                        action_option = action_option + `</div></div>`;
                    }
                    $('#basic-1 tbody').append(`<tr id="trid-${rowData.id}" data-id="${rowData.id}"><td>${rowData.name}</td><td>${rowData.bn_name}</td><td>${rowData.division_name}</td><td>${rowData.area_code?rowData.area_code:'N/A'}</td>
                    <td class="text-center">${update_status_btn}</td>
                    <td>${action_option}</td></tr>`);
                    if(data.hasEditPermission){
                        new Switchery($('#trid-'+rowData.id).find('input')[0], $('#trid-'+rowData.id).find('input').data());
                    }
                })
                
                $('#basic-1').DataTable()
            }else if(data.area_type=='upazila'){
                $('#basic-1 thead tr').empty().append(`<th>Name(English)</th><th>Name(Bangla)</th><th>District</th><th>Division</th><th>Area Code</th><th>Status</th><th>Action</th>`)
                
                $('#basic-1 tbody').empty();
                $('#basic-1').show();
                $.each(data.area,function(key,rowData){
                    let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                    if(data.hasEditPermission){
                        update_status_btn = `<span class="mx-2">${rowData.status==0?'Inactive':'Active'}</span><input
                        data-status="${rowData.status==0?1:0}"
                        id="status_change" type="checkbox" data-toggle="switchery"
                        data-color="green" data-secondary-color="red" data-size="small" checked />`;
                    }
                    let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                    if(data.hasAnyPermission){
                        action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                        if(data.hasEditPermission){
                            action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-parent-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                        }
                        if(data.hasDeletePermission){
                            action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                        }
    
                        action_option = action_option + `</div></div>`;
                    }
                    $('#basic-1 tbody').append(`<tr id="trid-${rowData.id}" data-id="${rowData.id}"><td>${rowData.name}</td><td>${rowData.bn_name}</td><td>${rowData.district_name}</td><td>${rowData.division_name}</td><td>${rowData.area_code?rowData.area_code:'N/A'}</td>
                    <td class="text-center">${update_status_btn}</td>
                    <td>${action_option}</td></tr>`);
                    if(data.hasEditPermission){
                        new Switchery($('#trid-'+rowData.id).find('input')[0], $('#trid-'+rowData.id).find('input').data());
                    }
                })
                $('#basic-1').DataTable()
            }
            
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
    })
})