function CtrlMessage(){
	this.init = init;
	this.popupDelete = popupDelete;
	this.showMessageDetail = showMessageDetail;
	this.showContactDetail = showContactDetail;
	this.doScrollContact = doScrollContact;
	this.setKeyword = setKeyword;
	
	var keyword = "";
	var messageContent;
	var messageDeleteID, messageDeleteName;
	var btnMessageReads;
	var aMessageDeletesYes, aMessageDeleteYes, aMessageDeleteNo, aMessageNew;
	var offset_c=5;
	var scroll = true;
	
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
		if ($('#contact-pesan').scrollTop() == ($('#contact-pesan').get(0).scrollHeight - $('#contact-pesan').height()) && scroll == true) {
			$('#loader-contact').slideDown();
			
			scroll      = false;		        
			var id  	= $('#member').val();
			var url 	= base_url+'message/showContactDetail/'+offset_c;

			$.ajax({
				type: 'POST',
				data: 'ajax=1&keyword='+keyword+'&id='+id,
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
						$('#habis-contact').slideDown();
						scroll   = false;
					}
				}
			});
			return false;
		}
	}
	
	
	function setKeyword(e){
		keyword = e;
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
	this.doScroll = doScroll;
	
	var formMessageDetail;
	var btnSend;
	var member;
	var offset=10;
	var scrolling=true;
	var lastMessage = "";
	
	function init(){
		initComponent();
		initEventlistener();
		initUpdateMessage();
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
	
	function doScroll(){
		if ($('.content-pesan').scrollTop() == 0 && scrolling==true) {
			$('#loader-message').slideDown();
			
			scrolling       = false;
			var total_nota  = $('#total-message').val();
			var member  	= $('#member').val();
			var url         = base_url+'message/ajax_message/'+offset;
			
			$.ajax({
				type: 'POST',
				data: 'ajax=1&member='+member,
				url: url,
				async: false,
				success: function(msg) {
					if (msg){
						$('#message-ajax').prepend(msg);
						$('#loader-message').slideUp();
						$('.content-pesan').scrollTop(50);
						$('#total-message').val(total_nota+10);
						
						offset      = offset+10;
						scrolling   = true;
					}else{
						$('#loader-message').slideUp();
						$('#habis').slideDown();
						
						scrolling   = false;
					}
				}
			});
			return false;
		}
	}
	
	function doSend(){
		if(formMessageDetail.txtMessage.value == ""){
			Materialize.toast("Anda belum menulis pesan", 4000);			
			return;
		}
		
		if(lastMessage == formMessageDetail.txtMessage.value){
			Materialize.toast("Anda tidak dapat mengirim pesan yang sama", 4000);			
			return;
		}
		
		lastMessage = formMessageDetail.txtMessage.value;
		
		$.ajax({
			type: 'POST',
			data: "id="+member+"&message="+formMessageDetail.txtMessage.value,
			url: base_url+'message/doMessageSend',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					
					
					$("#message-ajax").append("<div class='row'><div class='pesanmu'>"+response.message.message.replace(/(?:\r\n|\r|\n)/g, '<br />')+" <br><span class='deep-orange-text text-lighten-5' style='font-size:10px;text-align:right;'>"+response.message.create_date+"</span></div></div>");
					formMessageDetail.txtMessage.value = "";
					
					ctrlMessage.showContactDetail(member);
					
					$(".content-pesan").animate({ scrollTop: $(".content-pesan")[0].scrollHeight }, "slow");
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
		});
	}
	
	function setMember(e){
		member = e;
	}
	
	function initUpdateMessage(){
		setInterval(function(){ 
			if(member != null){
				$.ajax({
					type: 'POST',
					data: "member="+member,
					url: base_url+'message/getUpdateMessageDetail',
					success: function(result) {
						var response = JSON.parse(result);
						if(response.result == 1){
							for(var i = 0; i <= response.messages.length - 1;i++){
								var object = response.messages[i];
								var date = new Date(object.create_date);
								
								if(object.flag_from == 0){
									$("#message-ajax").append("<div class='row'><div class='pesanmu'>"+object.message.replace(/(?:\r\n|\r|\n)/g, '<br />')+" <br><span class='deep-orange-text text-lighten-5' style='font-size:10px;text-align:right;'>"+date.getHours() + ":" + date.getMinutes()+"</span></div></div>");
								}else{
									$("#message-ajax").append("<div class='row'><div class='pesanku'>"+object.message.replace(/(?:\r\n|\r|\n)/g, '<br />')+" <br><span class='deep-orange-text text-lighten-5' style='font-size:10px;text-align:right;'>"+date.getHours() + ":" + date.getMinutes()+"</span></div></div>");
								}
							}
							
							$(".content-pesan").animate({ scrollTop: $(".content-pesan")[0].scrollHeight }, "slow");
						}else{
							if(response.messageCode != 2){
								Materialize.toast(response.message, 4000);
							}
						}
					}
				});
			}
		}, 5000);
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
				 var response = JSON.parse(result);
				if(response.result == 1){
					top.location.reload();
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