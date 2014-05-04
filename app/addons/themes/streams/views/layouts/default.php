<!doctype html>

<!--[if lt IE 7]>
<html class="nojs ms lt_ie7" lang="en"><![endif]-->
<!--[if IE 7]>
<html class="nojs ms ie7" lang="en"><![endif]-->
<!--[if IE 8]>
<html class="nojs ms ie8" lang="en"><![endif]-->
<!--[if gt IE 8]>
<html class="nojs ms" lang="en"><![endif]-->

<html lang="en">

<head>
    <?php $this->insert('theme::partials/metadata'); ?>
</head>

<body data-spy="scroll" data-target=".spybar">

<?php $this->insert('theme::partials/header'); ?>

<section id="main">

    <section class="container">

        <?php echo $this->content; ?>

    </section>

</section>
<!-- #main -->

<!-- Footer -->

</body>
</html>