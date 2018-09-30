function sendAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url:     "ajax/action_ajax_form.php", //url �������� (action_ajax_form.php)
        type:     "POST", //����� ��������
        dataType: "html", //������ ������
        data: $("#"+ajax_form).serialize(),  // ����������� ������
        success: function(response) { //������ ���������� �������
            result = $.parseJSON(response);
            $('#result_form').html('Name: '+result.name+'<br>Phone: '+result.phonenumber);
            //$('#result_form').html('Name: '+result.name);
        },
        error: function(response) { // ������ �� ����������
            $('#result_form').html('AJAX Error');
        }
    });
}