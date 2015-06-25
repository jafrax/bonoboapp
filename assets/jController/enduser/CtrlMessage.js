function CtrlMessage(){
	this.init = init;
	this.popupDelete = popupDelete;
	this.showMessageDetail = showMessageDetail;

	var messageContent;
	var messageDeleteID, messageDeleteName;
	var btnMessageReads;
	var aMessageDeletesYes, aMessageDeleteYes, aMessageDeleteNo, aMessageNew;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		messageContent = $("#messageContent");
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
	
	function popupDelete(e,n){
		messageDeleteID.value = e;
		messageDeleteName.innerHTML = "'"+n.replace("+"," ")+"'";
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
			}
		});
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
					alert(response.message);
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
					alert(response.message);
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
					alert(response.message);
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
			alert("Anda belum menulis pesan");
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
				}else{
					alert(response.message);
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
	
	var cmbMessageAnggota, emailsTo, txtMessage;
	var btnSend;
	var divEmailsTo;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		divEmailsTo = $("#divEmailsTo");
		emailsTo = $('#emailsTo');
		cmbMessageAnggota = $hs("cmbMessageAnggota");
		txtMessage = $hs("txtMessage");
		btnSend = $hs("btnSend");
		
		emailsTo.materialtags();
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
			alert("Belum ada pesan yang anda tulis");
			return;
		}
		
		if(cmbMessageAnggota.checked){
			checked = "1";
		}
		
		$.ajax({
			type: 'POST',
			data: "emails="+emailsTo.val()+"&message="+txtMessage.value+"&checkbox="+checked,
			url: base_url+'message/doMessageNewSend',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"message";
				}else{
					alert(response.message);
				}
			}
		});
	}
}

