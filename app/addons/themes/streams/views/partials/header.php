<nav class="navbar navbar-default main" role="navigation">
    <!--<div class="container">-->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="navbar-brand" href="#"><i class="ion-grid"></i>&nbsp;&nbsp;Streams</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php foreach (Module::getAll() as $module): ?>
                    <li>
                        <a href="<?php echo url('admin/' . $module->slug); ?>">
                            <?php echo $module->getName(); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/admin/logout">Hello <strong>Ryan Thompson</strong></a></li>
                <li><a class="icon" href="/admin/logout"><i class="ion-ios7-search-strong"></i></a></li>
                <li><a class="icon" href="/admin/logout"><i class="ion-more"></i></a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    <!--</div>-->
    <!-- /.container-fluid -->
</nav>