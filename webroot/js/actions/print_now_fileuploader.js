/*
 * jQuery File Upload Plugin JS Example 6.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */

Array.prototype.findIndex = function(value){
    var ctr = "";
    for (var i=0; i < this.length; i++) {
        // use === to check for Matches. ie., identical (===), ;
        if (this[i] == value) {
            return i;
        }
    }
    return ctr;
};

var uploadedfiles = new Array();

$.widget('blueimpUIX.fileupload', $.blueimpUI.fileupload, {
    options: {
        // Override the callback for upload progress events:
        progress: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10) + '%'
        },
        // Override the callback for global upload progress events:
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10) + '%'
        }
    }
});

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload();

    $('#fileupload').fileupload('option', {
        maxNumberOfFiles: 5,
        maxFileSize: 2097152,
        acceptFileTypes: /(\.|\/)(jpe?g|png|pdf|docx?)$/i,
    });

    // Enable iframe cross-domain access via redirect page:
    var redirectPage = window.location.href.replace(
        /\/[^\/]*$/,
        '/result.html?%s'
    );

    // callback: 'send'
    $('#fileupload').bind('fileuploadsend', function (e, data) {
        if (data.dataType.substr(0, 6) === 'iframe') {
            var target = $('<a/>').prop('href', data.url)[0];
            if (window.location.host !== target.host) {
                data.formData.push({
                    name: 'redirect',
                    value: redirectPage
                });
            }
        }
    }).bind('fileuploaddone', function (e, data) {
        for (var i=0, files=data.result, l=files.length, file=files[0]; i<l; file=files[++i]) {
            uploadedfiles.push(file.uuid);
        }
        $('div#upfiles').html(tmpl("template-uploaded-filename", uploadedfiles.toString()));
    }).bind('fileuploaddestroy', function (e, data) {
        var urlStr = data.url, strSearch = "?file=", delUUID='';
        delUUID = urlStr.substring(urlStr.indexOf(strSearch)+strSearch.length);
        uploadedfiles.splice(uploadedfiles.findIndex(delUUID), 1);
        $('div#upfiles').html(tmpl("template-uploaded-filename", uploadedfiles.toString()));
    });

    // Open download dialogs via iframes,
    // to prevent aborting current uploads:
    $('#fileupload .files').delegate(
        'a:not([rel^=gallery])',
        'click',
        function (e) {
            e.preventDefault();
            $('<iframe style="display:none;"></iframe>')
                .prop('src', this.href)
                .appendTo(document.body);
        }
    );
});

