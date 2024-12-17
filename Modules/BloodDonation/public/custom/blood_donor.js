

$(document).on('input','#add_donor_form #name',function(){
    var donor_name =$(this).val().toUpperCase().replace('.', '').replace(/ /g, '_');
    $('#add_donor_form #username').val(donor_name);
})

$(document).on('input','#add_donor_form #phone',function(){
    var donor_phone = $(this).val();
    $('#add_donor_form #password').val(donor_phone);
})

function getDivisionInfo(type,id,target){
    $rr = $.ajax({
        type : 'GET',
        url :base_url+'/blood-donation/donor/get/division-information/'+type+'/'+id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        }, 
        success: function(data){
            var option = `<option value="">Select Please</option>`;
            $.each(data,function(key,val){
                option = option+`<option value="${val.id}">${val.name}</option>`;
            })

             $(target).empty().append(option).trigger('change');
        },
        error : function(){

        }
    });
    
}

$(document).on('change','#add_donor_form #division',function(){
   getDivisionInfo('district',$(this).val(),'#add_donor_form #district')
})

$(document).on('change','#add_donor_form #district',function(){
    getDivisionInfo('upazila',$(this).val(),'#add_donor_form #upazila')
})


$(document).on('submit','#add_donor_form',function(e){
    e.preventDefault();
    $('#add_donor_form #submit_btn').html(submit_btn_after+'....');
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
        success: function (data) {
            $('button[type=submit]', '#add_donor_form').html(submit_btn_before);
            $('button[type=submit]', '#add_donor_form').removeClass('disabled');
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function(){
                
            })
        },
        error: function (err) {
            $('button[type=submit]', '#add_donor_form').html(submit_btn_before);
            $('button[type=submit]', '#add_donor_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '##add_donor_form').click();
                });

            }

            $('#add_donor_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#add_donor_form #'+idx);
                var exp = idx.replace('.','_');
                $('#add_donor_form #'+exp).addClass('border-danger is-invalid')
                $('#add_donor_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#add_donor_form #'+exp).next('.err-mgs').empty().append(val);

                $('#add_donor_form #'+exp+"_err").empty().append(val);
            })
        }
    })
});


