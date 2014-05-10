<table class="table table-striped">
    <?php echo View::make('streams/entry/partials/table/thead', array('columns' => $columns)); ?>
    <?php echo View::make('streams/entry/partials/table/tbody', array('columns' => $columns, 'entries' => $entries)); ?>
    <?php echo View::make('streams/entry/partials/table/tfoot', array('columns' => $columns)); ?>
</table>