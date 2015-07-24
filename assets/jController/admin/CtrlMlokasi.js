function search(id,url) {
	var search = $('#'+id).val();
	if (search == '') {
		var search='null';
	}
	$.ajax({
		type: 'POST',
		data: 'search='+search,
		url: base_url+url,
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
    //Date range picker
    $('#tanggalindong').daterangepicker();
});