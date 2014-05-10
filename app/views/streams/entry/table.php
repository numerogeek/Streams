<table class="table table-striped">
    <?php //echo $thead; ?>
    <?php echo View::make('streams/entry/partials/table/tbody', array('entries' => $entries)); ?>
    <?php //echo $tfoot; ?>
</table>