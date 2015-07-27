/*
 * Author : Dinar Wahyu Wibowo
 */
 
$(document).ready(function() {

	/*NUMBER ONLY*/
	jQuery('.numbersOnly').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	/*NUMBER ONLY*/

	/*NUMBER ONLY*/
	jQuery('.numbersOnlyLicense').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	    var type = $('#duration_type').val();
	    var dur = $('#duration');
	    if (type == 'd') {
	    	if (dur.val() >= 31){dur.val('31')}
	    }else if (type == 'm') {
	    	if (dur.val() >= 12){dur.val('12')}
	    }else if (type == 'y') {
	    	if (dur.val() >= 10){dur.val('10')}
	    };
	});
	/*NUMBER ONLY*/


});

// ERROR DAN SUCCESS NOTIFICATION



function box_success(e){
	var box = '<div class="alert alert-success alert-dismissable" style="width:300px">'
                    +'<i class="fa fa-check"></i>'
                    +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                    +'<b>Success!</b> '+e+'.'
                +'</div>';
    return box;
}

function box_error(e){
	var box = '<div class="alert alert-danger alert-dismissable" style="width:300px">'
                    +'<i class="fa fa-check"></i>'
                    +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                    +'<b>Alert!</b> '+e+'.'
                +'</div>';
    return box;
}

// END ERROR DAN SUCCESS NOTIFICATION