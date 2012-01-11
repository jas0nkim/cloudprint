<!-- include javascript files -->
<!--
<script src="/js/uploader/vendor/jquery.ui.widget.js"></script>
<script src="/js/uploader/jquery.iframe-transport.js"></script>
<script src="/js/uploader/jquery.fileupload.js"></script>
<script src="/js/actions/print_now_fileuploader_basic.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/actions/print_now_ajaxform.js"></script>
-->

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

<div id="home_view">
    <form id="print_form" action="/members/print_process" method="post">
        <div id="message"></div>
        <div id="upload_box">
            <input id="fileupload" type="file" name="files[]" multiple>
        </div>
        <select id="printer" name="printer">
            <option value="">Select Printer...</option>
            <?php foreach ($content_data['printers'] as $printer): ?>
            <option value="<?= $printer->id ?>"><?= $printer->uuid ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Submit" />
    </form>
</div>