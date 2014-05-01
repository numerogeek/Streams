<?php foreach ($themes as $theme): ?>
    <p>
        <strong>
            <?php echo $theme->getName(); ?>
        </strong>
        &nbsp;
        <?php echo \HTML::link('admin/addons/themes/install/'.$theme->slug, 'Install'); ?>
         -
        <?php echo \HTML::link('admin/addons/themes/uninstall/'.$theme->slug, 'Uninstall'); ?>
    </p>
<?php endforeach; ?>