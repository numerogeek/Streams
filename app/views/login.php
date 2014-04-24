<?php echo Session::get('message'); ?>
<br>
<?php echo Form::open(array('url' => 'admin/login', 'method' => 'post')); ?>
<?php echo Form::text('email'); ?>
<br>
<?php echo Form::text('password'); ?>
<br>
<?php echo Form::submit('Login'); ?>
<?php echo Form::close(); ?>