function CtrlMessage(){
	this.init = init;
	this.popupDelete = popupDelete;
	this.showMessageDetail = showMessageDetail;
	this.showContactDetail = showContactDetail;
	this.doScrollContact = doScrollContact;
	this.setKeyword = setKeyword;
	this.setLastUserID = setLastUserID;

	var keyword = "";
	var lastUserID = 0;
	var messageContent;
	var messageDeleteID, messageDeleteName;
	var btnMessageReads;
	var aMessageDeletesYes, aMessageDeleteYes, aMessageDeleteNo, aMessageNew;
	var offset_c=5;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		messageContent = $("#messageContent");
		contact = $("#contact-pesan");
		messageDeleteID = $hs("messageDeleteID");
		messageDeleteName = $hs("messageDeleteName");
		btnMessageReads = $hs("btnMessageReads");
		aMessageDeletesYes = $hs("aMessageDeletesYes");
		aMessageDeleteYes = $hs("aMessageDeleteYes");
		aMessageDeleteNo = $hs("aMessageDeleteNo");
		aMessageNew = $hs("aMessageNew");
	}
	
	function initEventlistener(){
		btnMessageReads.onclick = function(){
			doMessageReads();
		};
		
		aMessageDeletesYes.onclick = function(){
			doDeletes();
		};
		
		aMessageDeleteYes.onclick = function(){
			doDelete();
		};
		
		aMessageDeleteNo.onclick = function(){
			doDeleteNo();
		};
		
		aMessageNew.onclick = function(){
			showNewMessage();
		};
	}
	
	function doScrollContact(){
		if ($('#contact-scroll').scrollTop() == ($('#contact-scroll').get(0).scrollHeight - $('#contact-scroll').height()) && scroll == true) {
			$('#loader-contact').slideDown();
			
			scroll      = false;		        
			var id  	= $('#member').val();
			var url 	= base_url+'message/showContactDetail/'+id;

		   // $('#contact-scroll').scrollTo(0, ($('#contact-scroll').get(0).scrollHeight - 50) );
			$.ajax({
				type: 'POST',
				data: 'ajax=1&keyword='+keyword+'&id='+ id + "&lastUserID="+lastUserID,
				url: url,
				async: false,
				success: function(msg) {
					if (msg){
						$('#contact-pesan').append(msg);
						$('#loader-contact').slideUp();
						offset_c = offset_c + 5;		                    
						scroll   = true;		                    
					}else{
						$('#loader-contact').slideUp();
						scroll   = false;
						$('#habis-contact').slideDown();
					}
				}
			});
			return false;
		}
	}
	
	
	function setKeyword(e){
		keyword = e;
	}
	
	function setLastUserID(e){
		lastUserID = e;
	}
	
	function popupDelete(e,n){
		messageDeleteID.value = e;
		messageDeleteName.innerHTML = n.replace(/\+/gi, " ");
	}
	
	function showNewMessage(){
		$.ajax({
			type: 'POST',
			data: "",
			url: base_url+'message/showNewMessage',
			success: function(result) {
				messageContent.html(result);
			}
		});
	}
	
	function showMessageDetail(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'message/showMessageDetail',
			success: function(result) {
				messageContent.html(result);
				ctrlMessage.showContactDetail(e);
				
				scrolling   = true;
				$('.modal-trigger').leanModal();
				$(".content-pesan").animate({ scrollTop: $(".content-pesan")[0].scrollHeight }, "slow");
				Materialize.updateTextFields();
				
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
						}
					}
				});
			}
		});
	}

	function showContactDetail(e){
		/*
		*	-------------------------------------------------	
		*	Turn Off This Function because this function 
		*	the keyword search contact not support on this 
		*	function.
		*	Turn Off by : Heri Siswanto Bayu Nugroho
		*	Date : 06 Oct 2015
		*	-------------------------------------------------
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'message/showContactDetail',
			success: function(result) {
				contact.html(result);
				$('.modal-trigger').leanModal();
			}
		});
		*/
	}
	
	function doDeletes(){
		$.ajax({
			type: 'POST',
			data: "",
			url: base_url+'message/doDeletes',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"message";
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
		});
	}
	
	function doDelete(){
		$.ajax({
			type: 'POST',
			data: "id="+messageDeleteID.value,
			url: base_url+'message/doDelete',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"message";
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
		});
	}
	
	function doDeleteNo(){
		messageDeleteID.value = "";
		messageDeleteName.innerHTML = "";
	}
	
	function doMessageReads(){
		$.ajax({
			type: 'POST',
			data: "",
			url: base_url+'message/doMessageReads',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"message";
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
		});
	}
}

function CtrlMessageDetail(){
	this.init = init;
	this.setMember = setMember;
	
	var formMessageDetail;
	var btnSend;
	var member;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formMessageDetail = $hs("formMessageDetail");
		btnSend = $hs("btnSend");
	}
	
	function initEventlistener(){
		btnSend.onclick = function(){
			doSend();
		};
	}
	
	function doSend(){
		if(formMessageDetail.txtMessage.value == ""){
			Materialize.toast("Anda belum menulis pesan", 4000);			
			return;
		}
		
		$.ajax({
			type: 'POST',
			data: "id="+member+"&message="+formMessageDetail.txtMessage.value,
			url: base_url+'message/doMessageSend',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					
					ctrlMessage.showMessageDetail(member);
					ctrlMessage.showContactDetail(member);
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
					
		});
	}
	
	function setMember(e){
		member = e;
	}
}


function CtrlMessageNew(){
	this.init = init;
	
	var cmbMessageAnggota, memberTo, txtMessage;
	var btnSend;
	var divEmailTo;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		divEmailsTo = $("#divEmailsTo");
		memberTo = $hs('memberTo');
		cmbMessageAnggota = $hs("cmbMessageAnggota");
		txtMessage = $hs("txtMessage");
		btnSend = $hs("btnSend");
		
		initComboBox();
	}
	
	function initEventlistener(){
		btnSend.onclick = function(){
			doSend();
		};
		
		cmbMessageAnggota.onclick = function(){
			if(cmbMessageAnggota.checked){
				divEmailsTo.slideUp("slow");
			}else{
				divEmailsTo.slideDown("slow");
			}
		};
	}
	
	function doSend(){
		var checked = "0";
		
		if(txtMessage.value == ""){
			Materialize.toast("Belum ada pesan yang anda tulis", 4000);			
			return;
		}
		
		if(cmbMessageAnggota.checked){
			checked = "1";
		}
		
		$.ajax({
			type: 'POST',
			data: "member="+memberTo.value+"&message="+txtMessage.value+"&checkbox="+checked,
			url: base_url+'message/doMessageNewSend',
			success: function(result) {
				 location.reload();
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"message";
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
		});
	}
}

$(document).ready(function() {
    $.validator.setDefaults({
        ignore: []
    });
    
    $('#pesannyanota').validate({
        rules:{
            message     : {required: true},
        },
    });
    if ($(".content-pesan").length > 0) {
    	$(".content-pesan").animate({ scrollTop: $(".content-pesan")[0].scrollHeight }, "slow");
    	scrolling = true;
    };

  	if ($("#contact-scroll").length > 0) {
    	$("#contact-scroll").animate({ scrollTop: 0 }, "slow");
    	scroll = true;
    };

})