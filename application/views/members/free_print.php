<script type="text/javascript" src="/js/axuploader.js"></script>
<script type="text/javascript" src="/js/uploader.js"></script>

<?php echo heading('Print your documents now', 1, 'class="page_header"'); ?>

<div id="home_view">

    <?php $upload_form = array('class' => 'form', 'enctype' => 'multipart/form-data'); ?>
    <?php echo form_open('members/print_now', $upload_form); ?>

    <?php echo form_label('Select files:', 'uploads'); ?><br />
    <div class="prova"></div>

    <div class="form_button"><?php echo form_submit('submit', 'Sign Up!'); ?></div>
    <?php echo form_close(); ?>
</div>