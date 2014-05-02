<?php $this->start('content'); ?>
<h1>Welcome!</h1>
<p>Hello <?php echo Sentry::getUser()->first_name; ?></p>
<?php $this->end(); ?>
