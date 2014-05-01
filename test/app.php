<?php $this->layout('template') ?>

<?php $this->title = 'User Profile' ?>

<?php echo Session::get('message'); ?>
<br>
<?php echo HTML::link('admin/logout', 'Logout'); ?>