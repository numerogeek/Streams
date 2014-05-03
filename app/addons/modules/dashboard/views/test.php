<?php $this->start('content'); ?>
<h1>Welcome!</h1>
<p>Hello <?php echo Sentry::getUser()->email; ?></p>
<?php $this->end(); ?>
