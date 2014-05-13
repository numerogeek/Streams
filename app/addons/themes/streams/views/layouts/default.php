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
    <?php $this->insert('theme::partials/metadata', array('title' => $this->title)); ?>
</head>

<body data-spy="scroll" data-target=".spybar" data-layout="default">

<div id="launch" style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; z-index: 9999; display: none;">
    <h1>
        Oh hai
        <br>
        <small>
            <a href="#" onclick="$('#main').toggleClass('blur'); $('#launch').toggle(); return false;">Bai</a>
        </small>
    </h1>
</div>

<section id="main">

    <?php $this->insert('theme::partials/header'); ?>

    <section class="container-fluid">

        <?php echo $this->content(); ?>

        <small class="text-muted">
            &copy; <?= date('Y'); ?> AnomalyLabs
        </small>

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