function sendAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url:     "ajax/action_ajax_form.php", //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#result_form').html('Name: '+result.name+'<br>Phone: '+result.phonenumber);
            //$('#result_form').html('Name: '+result.name);
        },
        error: function(response) { // Данные не отправлены
            $('#result_form').html('AJAX Error');
        }
    });
}