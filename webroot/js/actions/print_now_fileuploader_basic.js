$(function () {
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload();

    // add options
    $('#fileupload').fileupload(
        'option',
        {
            dataType: 'json',
            url: '/members/upload',
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $('<p />').text(file.name).appendTo('div#upload_box');
                    $('<input />').attr({
                        type:   'hidden',
                        name:   'somename',
                        id:     'somename',
                        value:  'value'
                    }).appendTo('div#upload_box');
                    if (file.error != undefined) {
                        $('<p style="color: red" />').text(file.error).appendTo('div#upload_box');
                    }

                });
            }

        }
    );
});
