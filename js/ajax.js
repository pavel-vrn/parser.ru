function sendAjaxRules(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#result_form').html('Name: '+result.rule_id+'<br>Phone: '+result.phonenumber);
            //$('#result_form').html('Name: '+result.name);
        },
        error: function(response) { // Данные не отправлены
            $('#result_form').html('AJAX Error');
        }
    });
}

function sendAjaxWords(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "GET", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#result_form').html('Name: '+result.word_id+'<br>Phone: '+result.phonenumber);
            //$('#result_form').html('Name: '+result.name);
        },
        error: function(response) { // Данные не отправлены
            $('#result_form').html('AJAX Error');
        }
    });
}