<html>
<head>
    <?php \Assets::add(url('pace.min.js')); ?>
    <?php \Assets::add(url('pace.default.css')); ?>
    <?php echo \Assets::js(); ?>
    <?php echo \Assets::css(); ?>
</head>
<body>
<aside style="background-color: #181818; width: 50px; position: fixed; top: 0; left: 0; height: 100%;">

</aside>

<section style="position: fixed; left: 50px; top: 0; bottom: 0; right: 0; background-color: #e5e5e5; padding: 25px;">

    <div
        style="padding: 10px; background: #fff; margin-bottom: 30px; border-radius: 2px; font-size: 13px; color: #90939a; font-weight: 300; -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25); moz-box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25); box-shadow: 0 1px 1px 0 rgba(0,0,0,0.25);">
        <?php echo $this->content; ?>
    </div>
</section>
</body>
</html>