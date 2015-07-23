$(document).on('click','div.page ul li a',function() {
	var url = $(this).attr('href');
	$.ajax({
		type: 'POST',
		data: 'ajax=1',
		url: url,
		success: function(msg) {
			$('.div-paging').html(msg);
		}
	});
	return false;
});
});
$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});