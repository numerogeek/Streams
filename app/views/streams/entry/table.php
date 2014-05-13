<table class="table table-striped">
    <?php echo View::make('streams/entry/partials/table/thead', array('columns' => $columns, 'buttons' => $buttons)); ?>
    <?php echo View::make('streams/entry/partials/table/tbody', array('columns' => $columns, 'rows' => $rows, 'buttons' => $buttons)); ?>
    <?php echo View::make('streams/entry/partials/table/tfoot', array('columns' => $columns)); ?>
</table>