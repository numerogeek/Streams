<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Streams</title>
    <style>
        body {
            background-image: url('../_tmp/bg.jpg');
            background-repeat: no-repeat;
            background-position: top;
            background-size: cover;
        }

        img {
            margin-top: 100px;
            margin-bottom: 15px;
            width: 300px;
        }

        form {
            width: 350px;
            margin: auto;
            padding: 20px;
            background: #fff;
            margin-bottom: 30px;
            border-radius: 2px;
            font-size: 13px;
            color: #90939a;
            font-weight: 300;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25);
            -moz-box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25);
        }
    </style>
</head>
<body>

<?php echo Session::get('message'); ?>
<br>

<center>
    <img src="../_tmp/logo.png">
</center>

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

</body>
</html>