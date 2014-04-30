<?php foreach ($modules as $module): ?>
    <p>
        <strong>
            <?php echo $module->getName(); ?>
        </strong>
        &nbsp;
        <?php echo \HTML::link('admin/addons/modules/install/'.$module->slug, 'Install'); ?>
         -
        <?php echo \HTML::link('admin/addons/modules/uninstall/'.$module->slug, 'Uninstall'); ?>
    </p>
<?php endforeach; ?>