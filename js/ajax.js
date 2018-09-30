function sendAjaxRules(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url �������� (action_ajax_form.php)
        type:     "POST", //����� ��������
        dataType: "html", //������ ������
        data: $("#"+ajax_form).serialize(),  // ����������� ������
        success: function(response) { //������ ���������� �������
            result = $.parseJSON(response);
            $('#result_form').html('Name: '+result.rule_id+'<br>Phone: '+result.phonenumber);
            //$('#result_form').html('Name: '+result.name);
        },
        error: function(response) { // ������ �� ����������
            $('#result_form').html('AJAX Error');
        }
    });
}

function sendAjaxWords(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url �������� (action_ajax_form.php)
        type:     "GET", //����� ��������
        dataType: "html", //������ ������
        data: $("#"+ajax_form).serialize(),  // ����������� ������
        success: function(response) { //������ ���������� �������
            result = $.parseJSON(response);
            $('#result_form').html('Name: '+result.word_id+'<br>Phone: '+result.phonenumber);
            //$('#result_form').html('Name: '+result.name);
        },
        error: function(response) { // ������ �� ����������
            $('#result_form').html('AJAX Error');
        }
    });
}