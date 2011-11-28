<?php $this->load->view('layouts/includes/default_header'); ?>
<!-- main body start -->
<div id="content">
    <?php if (isset($content_data)): ?>
        <?php $this->load->view($this->router->fetch_class().'/'.$this->router->fetch_method(), $content_data); ?>
    <?php else: ?>
        <?php $this->load->view($this->router->fetch_class().'/'.$this->router->fetch_method()); ?>
    <?php endif; ?>

</div>
<!-- main body end -->
<?php $this->load->view('layouts/includes/default_footer'); ?>
