<?php $this->load->view('layouts/includes/default_header'); ?>
<!-- main body start -->
<div id="content">
    <?php echo validation_errors('<div class="error_message">', '</div>'); ?>
    <?php echo $this->session->flashdata('message'); ?>
    <?php if (!empty($message)) { echo $message; } ?>

    <?php if (!isset($controller)): ?>
        <?php $controller = $this->router->fetch_class(); ?>
    <?php endif; ?>

    <?php if (!isset($action)): ?>
        <?php $action = $this->router->fetch_method(); ?>
    <?php endif; ?>

    <?php if (isset($content_data)): ?>
        <?php $this->load->view($controller.'/'.$action, $content_data); ?>
    <?php else: ?>
        <?php $this->load->view($controller.'/'.$action); ?>
    <?php endif; ?>

</div>
<!-- main body end -->
<?php $this->load->view('layouts/includes/default_footer'); ?>
