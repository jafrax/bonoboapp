// ========== country ===========//
$(function(){
    $('#formCountry').validate({
        rules:{
            txtName: {required: true,maxlength: 100,remote: base_url+"admin/country/rules_code"},
            txtCode: {required: true,maxlength: 100,noSpace: true,remote: base_url+"admin/country/rules_code",},
            txtPhone: {required: true,minlength:2,maxlength: 100,noSpace: true,remote: base_url+"admin/country/rules_phone",},
        },
        messages:{
            txtName: {
                remote: jQuery.format("Nama negara sudah tersedia"),
                required: jQuery.format("Nama negara harus diisi")
            },
            txtCode: {
                remote: jQuery.format("Kode negara sudah tersedia"),
                required: jQuery.format("Kode negara harus diisi")
            },
            txtPhone: {
                remote: jQuery.format("Phone negara sudah tersedia"),
                required: jQuery.format("Phone negara harus diisi")
            }
        }
    });
    
    $('#change-password-form').validate({
        rules:{
            old: {
                required: true,
                maxlength: 100,
                remote: base_url+"benefactor_admin/admin/rules_password",
            },
            new_pass: {
                required: true,
                minlength:4,
                maxlength: 100,
            },
            re_new_pass: {
                required: true,
                equalTo:"#new_pass",
                maxlength: 100,
            },
            messages:{
                old: {
                    remote: jQuery.format("Old password is wrong!"),
                }
            }
        }
    });
})
// ========== end of admin ===========//

function filter(id,url) {
    var filter = $('#'+id).val();
    if (filter == '') {
        var filter='all';
    }
    $.ajax({
        type: 'POST',
        data: 'filter='+filter,
        url: url,
        success: function(msg) {
            if (msg == 'redirect') {
                window.location.reload();
            }else{
                $('.div-paging').html(msg); 
            }
        }
    });
}


$(function() {
$(".doDelete").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
var url = $(this).attr('href');
if(confirm("Are you sure you want to delete this?"))
{
 $.ajax({
   type: "POST",
   url: url,
   data: info,
   success: function(){
 }
});
  $(this).parents(".show").animate({ backgroundColor: "#003" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});

