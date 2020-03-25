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
        url:     'ajax_form.php', //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#'+result.calendar).append('<p>'+result.text+'</p>')
            //$('#result_form').html('Имя: '+result.name+'<br>Телефон: '+result.phonenumber);
            $('.popup-fade').fadeOut();
    	},
    	error: function(response) { // Данные не отправлены
            //$('#result_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
}