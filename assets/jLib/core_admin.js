$(document).ready(function() {
	$('#menu-show').click(function(){
	   $('.triangle').slideToggle(50);
	});
	$( "#datepicker" ).datepicker();
	$( "#datepicker1" ).datepicker();
	tinyMCE.init({
        // General options
        selector : 'textarea',
        height : 300,
        convert_urls: false,
        plugins: [
	        'advlist autolink lists link image charmap print preview anchor',
	        'searchreplace visualblocks code fullscreen',
	        'insertdatetime media table contextmenu paste  jbimages'
	    ],
	    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | youtube | jbimages'

	});
});

function fancy(){
	$(document).ready(function() {
		$('.various1').fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
		});
	});
}
$(document).ready(function() {
	$('.various1').fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
	});
});

var fade = function(id,s){
	s.tabs.removeClass(s.selected);
	s.tab(id).addClass(s.selected);
	return false;
};
$('#pageTab').idTabs(); 

var config = {
  '.chzn-select'           : {},
  '.chzn-select-deselect'  : {allow_single_deselect:true},
  '.chzn-select-no-single' : {disable_search_threshold:10},
  '.chzn-select-no-results': {no_results_text:'Oops, nothing found!'},
  '.chzn-select-width'     : {width:"100%"}
}

for (var selector in config) {
  $(selector).chosen(config[selector]);
}

$(document).ready(function() {
	$(".accordion .accord-header").click(function() {
		if($(this).next("div").is(":visible")){
			$(this).next("div").slideUp("normal");
		} else {
			$(".accordion .accord-content").slideUp("normal");
			$(this).next("div").slideToggle("normal");
		}
	});
});

//pagination
$(document).ready(function() {
	$('.pagination-box-area a').live('click',function() {
        var url = $(this).attr('href');
        $.ajax({
            type: 'POST',
            data: 'ajax=1',
            url: url,
            success: function(msg) {
                $('.div-paging').html(msg);
				fancy();
            }
        });
        return false;
    });
});

//SEARCH
function search(id,url) {
	var search = $('#'+id).val();
	if (search == '') {
		window.location.reload();
	}
	$.ajax({
		type: 'POST',
		data: 'filter='+search,
		url: base_url+url,
		success: function(msg) {
			$('.div-paging').html(msg);
			fancy();
		}
	});
}

$(document).ready(function(){
	$('#div-scroll').doubleScroll();
});
$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});


