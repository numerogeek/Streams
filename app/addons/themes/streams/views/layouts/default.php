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

    <section class="container-fluid">

        <?php echo $this->content; ?>

    </section>

</section>

<nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-right offcanvas" role="navigation">
    <a class="navmenu-brand" href="#">Brand</a>
    <ul class="nav navmenu-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Link</a></li>
        <li><a href="#">Link</a></li>
    </ul>
</nav>

</body>
</html>