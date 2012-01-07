<!-- include javascript files -->
<script src="/js/uploader/vendor/jquery.ui.widget.js"></script>
<script src="/js/uploader/jquery.iframe-transport.js"></script>
<script src="/js/uploader/jquery.fileupload.js"></script>
<script src="/js/actions/print_now_fileuploader_basic.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/actions/print_now_ajaxform.js"></script>

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