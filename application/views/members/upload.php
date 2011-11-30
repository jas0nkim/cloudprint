<?php echo heading('Upload your files', 1, 'class="page_header"'); ?>

<div id="home_view">

    <?php $upload_form = array('class' => 'form', 'enctype' => 'multipart/form-data'); ?>
    <?php echo form_open('members/do_upload', $upload_form); ?>

    <?php echo form_label('Select files:', 'uploads'); ?><br />
    <input name='uploads[]' type=file max="5" multiple><br />

    <div class="form_button"><?php echo form_submit('submit', 'Sign Up!'); ?></div>
    <?php echo form_close(); ?>
</div>