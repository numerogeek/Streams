<?php echo Session::get('message'); ?>
<br>
<?php echo Form::open(array('url' => 'admin/login', 'method' => 'post')); ?>
<?php echo Form::text('email'); ?>
<br>
<?php echo Form::password('password'); ?>
<br>
<?php echo Form::checkbox('remember', true, false, array('id' => 'remember')); ?>
<label for="remember">Remember me</label>
<br>
<?php echo Form::submit('Login'); ?>
<?php echo Form::close(); ?>