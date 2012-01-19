<!-- include css files -->
<link rel="stylesheet" href="/css/uploader/bootstrap-custom.css">
<link rel="stylesheet" href="/css/uploader/bootstrap-image-gallery.css">
<link rel="stylesheet" href="/css/uploader/jquery.fileupload-ui.css">
<style type="text/css">
.page-header {
    background-color: #f5f5f5;
    padding: 80px 20px 10px;
    margin: 0 -20px 20px;
    border: 1px solid #DDD;
    -webkit-border-radius: 0 0 6px 6px;
       -moz-border-radius: 0 0 6px 6px;
            border-radius: 0 0 6px 6px;
}
</style>

<!-- include javascript files -->
<script src="/js/uploader/vendor/jquery.ui.widget.js"></script>
<script src="/js/uploader/tmpl.min.js"></script>
<script src="/js/uploader/load-image.min.js"></script>
<!-- Bootstrap Modal and Image Gallery are not required, but included for the demo -->
<script src="/js/uploader/bootstrap-modal.1.4.0.min.js"></script>
<script src="/js/uploader/bootstrap-image-gallery.min.js"></script>
<script src="/js/uploader/jquery.iframe-transport.js"></script>
<script src="/js/uploader/jquery.fileupload.js"></script>
<script src="/js/uploader/jquery.fileupload-ui.js"></script>
<script src="/js/actions/print_now_fileuploader.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE >= 8 -->
<script src="/js/uploader/jquery.xdr-transport.js"></script>
<!-- postMessage Transport support can be added with the following plugin -->
<!--script src="jquery.postmessage-transport.js"></script-->

<?php echo heading('Print your documents now', 1, 'class="page_header"'); ?>

<div id="home_view">

    <form id="fileupload" action="/members/upload" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="span16 fileupload-buttonbar">
                <div class="progressbar fileupload-progressbar"><div style="width:0%;"></div></div>
                <span class="btn success fileinput-button">
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn primary start">Start upload</button>
                <button type="reset" class="btn info cancel">Cancel upload</button>
                <button type="button" class="btn danger delete">Delete selected</button>
                <input type="checkbox" class="toggle">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="span16">
                <table class="zebra-striped"><tbody class="files"></tbody></table>
            </div>
        </div>
    </form>

    <form id="freeprint" action="/members/submit_print_job" method="POST">
        <div id="upfiles">
            <input type="hidden" name="uploadedfiles" id="uploadedfiles" value="" />
        </div>
        <div id="selectprinter">
            <select id="printer" name="printer">
                <option value="">Select Printer...</option>
                <?php foreach ($content_data['printers'] as $printer): ?>
                <option value="<?= $printer->id ?>"><?= $printer->uuid ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="submitprintjob">
            <input type="submit" name="submit" value="Print" />
        </div>
    </form>

    <!-- gallery-loader is the loading animation container -->
    <div id="gallery-loader"></div>
    <!-- gallery-modal is the modal dialog used for the image gallery -->
    <div id="gallery-modal" class="modal hide fade">
        <div class="modal-header">
            <a href="#" class="close">&times;</a>
            <h3 class="title"></h3>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
            <a class="btn primary next">Next</a>
            <a class="btn info prev">Previous</a>
            <a class="btn success download" target="_blank">Download</a>
        </div>
    </div>
    <script>
    var fileUploadErrors = {
        maxFileSize: 'File is too big',
        minFileSize: 'File is too small',
        acceptFileTypes: 'Filetype not allowed',
        maxNumberOfFiles: 'Max number of files exceeded',
        uploadedBytes: 'Uploaded bytes exceed file size',
        emptyResult: 'Empty file upload result'
    };
    </script>
    <script id="template-upload" type="text/html">
    {% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
        <tr class="template-upload fade">
            <td class="preview"><span class="fade"></span></td>
            <td class="name">{%=file.name%}</td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            {% if (file.error) { %}
                <td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
            {% } else if (o.files.valid && !i) { %}
                <td class="progress"><div class="progressbar"><div style="width:0%;"></div></div></td>
                <td class="start">{% if (!o.options.autoUpload) { %}<button class="btn primary">Start</button>{% } %}</td>
            {% } else { %}
                <td colspan="2"></td>
            {% } %}
            <td class="cancel">{% if (!i) { %}<button class="btn info">Cancel</button>{% } %}</td>
        </tr>
    {% } %}
    </script>
    <script id="template-download" type="text/html">
    {% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
        <tr class="template-download fade">
            {% if (file.error) { %}
                <td></td>
                <td class="name">{%=file.name%}</td>
                <td class="size">{%=o.formatFileSize(file.size)%}</td>
                <td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
            {% } else { %}
                <td class="preview">{% if (file.thumbnail_url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery"><img src="{%=file.thumbnail_url%}"></a>
                {% } %}</td>
                <td class="name">
                    <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}">{%=file.name%}</a>
                </td>
                <td class="size">{%=o.formatFileSize(file.size)%}</td>
                <td colspan="2"></td>
            {% } %}
            <td class="delete">
                <button class="btn danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">Delete</button>
                <input type="checkbox" name="delete" value="1">
            </td>
        </tr>
    {% } %}
    </script>

</div>