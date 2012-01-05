<!-- include javascript files -->
<script src="/js/uploader/vendor/jquery.ui.widget.js"></script>
<script src="/js/uploader/jquery.iframe-transport.js"></script>
<script src="/js/uploader/jquery.fileupload.js"></script>
<script src="/js/uploader/application-basic.js"></script>

<div id="home_view">
    <div id="upload_box">
        <input id="fileupload" type="file" name="files[]" multiple>
    </div>
    <select id="printer" name="printer">
        <option value="">Select Printer...</option>
        <?php foreach ($content_data['printers'] as $printer): ?>
        <option value="<?= $printer->id ?>"><?= $printer->uuid ?></option>
        <?php endforeach; ?>
    </select>
</div>