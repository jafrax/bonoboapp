$(function() {
	$('input').on('keypress', function(e) {
		e.which !== 13 || $('[tabIndex=' + (+this.tabIndex + 1) + ']')[0].focus();
	});	
})
//function login(){
	$('#fsignin').validate({
		rules:{
			userid : {
				required: true
			},
			password: {
				required: true
			}
		},
		messages: {
			userid:{
				required: "Field ini dibutuhkan",
			},
			password:{
				required: "Field ini dibutuhkan",
			},
		},
	});
//}