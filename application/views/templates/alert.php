<?php
$flash_success = $this->session->flashdata('success');
$flash_error   = $this->session->flashdata('error');
?>

<?php if ($flash_success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $flash_success ?>
    </div>
<?php endif; ?>

<?php if ($flash_error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $flash_error ?>
    </div>
<?php endif; ?>
