<table class="table table-striped">
    <?php if ($showHeaders): ?>
        <?php echo View::make(
            'streams/entry/partials/table/thead',
            array('columns' => $columns, 'buttons' => $buttons)
        ); ?>
    <?php endif; ?>

    <?php echo View::make(
        'streams/entry/partials/table/tbody',
        array('columns' => $columns, 'rows' => $rows, 'buttons' => $buttons)
    ); ?>

    <?php if ($showFooter): ?>
        <?php echo View::make('streams/entry/partials/table/tfoot', array('columns' => $columns)); ?>
    <?php endif; ?>
</table>