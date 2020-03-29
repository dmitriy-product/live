$(document).ready(function($) {
	$('.popup-open').click(function() {
		$('.popup-fade').fadeIn();
		return false;
	});	
	
	$('.popup-close').click(function() {
		$(this).parents('.popup-fade').fadeOut();
		return false;
	});		

	$(document).keydown(function(e) {
		if (e.keyCode === 27) {
			e.stopPropagation();
			$('.popup-fade').fadeOut();
		}
	});
	
	$('.popup-fade').click(function(e) {
		if ($(e.target).closest('.popup').length == 0) {
			$(this).fadeOut();					
		}
    });	
    $("input[name='btn-form']").click(function() {
        ajaxForm('note-form');
        return false; 
    });
});

function ajaxForm (form){
    $.ajax({
        url:     'ajax_form.php',
        type:     "POST",
        dataType: "html",
        data: $("#"+form).serialize(),
        success: function(response) {
			result = $.parseJSON(response);
			$('#'+result.data).append('<div class="form-block"><p class="'+result.time+'" style="text-align:left">'+result.time+'</p><p>'+result.text+'</p></div>')
			$('.popup-fade').fadeOut();
			$("#"+form)[0].reset();
    	}
 	});
}