/*
 * Author : fatoni.work@gmail.com
 */
 
$(document).ready(function() {

	/*SELECT FIELD*/
	$('.select-standar').material_select();
	/*END SELECT FIELD*/

	/*MENU SLIDE*/
	$('.navmob').jPushMenu();
	/*END MENU SLIDE*/

	/*MODAL*/
	$('.modal-trigger').leanModal(
		{
      ready: function() { $("input:text:visible:first").focus(); Materialize.updateTextFields();}, // Callback for Modal open
      complete: function() { Materialize.updateTextFields(); } // Callback for Modal close
    });
	/*END MODAL*/

	/*TAB*/
	$('ul.tabs').tabs('select_tab', 'tab_id');
	/*END TAB*/

	/*DATE PICKER*/
	$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month		
		monthsFull: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
		monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
		selectYears: 15, // Creates a dropdown of 15 years to control year
		today: 'Hari ini',
		clear: 'Hapus',
		close: 'Tutup',
		formatSubmit: 'yyyy-mm-dd'
	});
	/*END DATE PICKER*/

	/*COLAPSE*/
	$('.collapsible').collapsible({
      	accordion : false 
    });
    /*END COLAPSE*/

    /*DROPDOWN*/
	$('.dropdown-button').dropdown();
	/*DROPDOWN*/

	/*CHOSEN SELECT*/
	var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:5},
      '.chosen-select-no-results': {no_results_text:'Oops, data tidak ada!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	/*END CHOSEN SELECT*/

	/*NUMBER ONLY*/
	jQuery('.numbersOnly').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	/*NUMBER ONLY*/

	/*EMAIL ONLY*/
	jQuery('.emailLow').keyup(function () { 
	    this.value = this.value.toLowerCase().replace(/ /g, '');
	});
	/*EMAIL ONLY*/

	/*EMAIL ONLY*/
	jQuery('.upperCase').keyup(function () { 
	    this.value = this.value.toUpperCase().replace(/[^\w\s]/gi, '');
	});
	/*EMAIL ONLY*/

	/*NUMBER FORMAT*/
	$('.berat').priceFormat({
	    limit: 7,
    	centsLimit: 2,
    	thousandsSeparator: '',
    	prefix: '',
	});
	/*NUMBER FORMAT*/
	
	$("input.rupiah").priceFormat({	    
	    limit: 18,
    	centsLimit: 2,
		centsSeparator: ".",
    	thousandsSeparator: "",
    	prefix: "",
	});

	$("input.ribuan").priceFormat({	    
	    limit: 18,
    	centsLimit: 0,
		centsSeparator: "",
    	thousandsSeparator: ".",
    	prefix: "",
	});
		
	Materialize.updateTextFields();
});


/*LOOPING NOTIFICATION MESSAGE*/

if($('.notifindong').length > 0){
	//alert('a');
	requestMessage();
	//$(window).load(function(){
		//alert('b');
	 // setInterval(requestMessage, 10000);
	//});
}



function requestMessage () {
	$.ajax({
		type:'POST',
		url: base_url+"notif",
		async: false,
		success:function(result){
			var response = JSON.parse(result);
			if(response.result == 1){
				if (response.message == 0){
					$('.notifindong').html('');
					$('.notifindong').hide();
				}else{
					$('.notifindong').html(response.message);
					$('.notifindong').fadeIn();
				}

				if (response.message2 == 0){
					$('.notifinnota').html('');
					$('.notifinnota').hide();
				}else{
					$('.notifinnota').html(response.message2);
					$('.notifinnota').fadeIn();
				}
				$(function(){
                    //setTimeout('requestMessage()',25000);
                })
			}else{
				window.location = base_url+"index/logout";	
			}
		}
	});	
}

/*END LOOPING NOTIFICATION MESSAGE*/