<script type="text/javascript">

    $(document).ready(function () {

        var selectize = $('#<?php echo $form_slug; ?>');

        selectize = selectize.selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'username',
            searchField: 'username',

            <?php if ($value): ?>
            options: [<?php echo json_encode($value->toArray()); ?>],
            <?php endif; ?>

            create: false,
            render: {
                /*item: function(item, escape) {
                 return '<div>' +
                 (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
                 (item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
                 '</div>';
                 },*/
                option: function (item, escape) {
                    return '<div>' + item.username + '</div>';
                }
            },
            load: function (query, callback) {
                if (!query.length) return callback();

                $('#<?php echo $form_slug; ?>').parent('div').find('.selectize-control').addClass('loading');

                $.ajax({
                    url: SITE_URL + 'streams_core/public_ajax/field/user/search/<?php echo $stream_namespace; ?>/<?php echo $field_slug; ?>?query=' + encodeURIComponent(query),
                    type: 'GET',
                    error: function () {
                        callback();
                    },
                    success: function (results) {
                        callback(results.users);
                    }
                });
            }
        });

        <?php if ($value): ?>
        selectize[0].selectize.setValue('<?php echo $value->id; ?>');
        <?php endif; ?>

        // Add our loader
        $('#<?php echo $form_slug; ?>').parent('div').find('.selectize-control').append('<?php echo Asset::img('loaders/808080.png', null, array('class' => 'animated spin spinner')); ?>');
    });
</script>