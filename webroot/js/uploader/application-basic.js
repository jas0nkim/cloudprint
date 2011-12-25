$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        url: '/members/upload',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $('<p/>').text(file.name).appendTo('div#upload_box');
            });
        }
    });
});
