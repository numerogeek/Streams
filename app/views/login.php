<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Streams</title>
    <style>
        body {
            background-color: #2f353e;
        }

        form {
            width: 350px;
            margin: auto;
            padding: 20px;
            background: #fff;
            margin-bottom: 50px;
            border-radius: 2px;
            font-size: 13px;
            color: #90939a;
            font-weight: 300;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25);
            -moz-box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25);
        }

        form input[type="text"], form input[type="password"] {
            border-radius: 3px;
            border: 1px solid #efefef;
            padding: 5px 0;
            text-indent: 10px;
            box-shadow: none;
            width: 100%;
        }

        form input[type="submit"] {
            background-color: #fff;
            border-radius: 3px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.3);
            padding: 5px 5px 5px 8px;
            border: 1px solid #f7f7f7;
            width: 100%;
            cursor: pointer;
        }

        hr {
            border: 1px solid #efefef;
            border-width: 1px 0 0 0;
        }
    </style>
</head>
<body>

<?php echo Session::get('message'); ?>
<br>

<center>
    <img src="http://anomaly.is/anomaly.jpg" width="300">
</center>

<?php echo Form::open(array('url' => 'admin/login', 'method' => 'post')); ?>
<?php echo Form::text('email'); ?>
<br>
<?php echo Form::password('password'); ?>
<br>
<?php echo Form::checkbox('remember', true, false, array('id' => 'remember')); ?>
<label for="remember">Remember me</label>
<hr/>
<?php echo Form::submit('Login'); ?>
<?php echo Form::close(); ?>

</body>
</html>