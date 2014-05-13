<thead>
<tr>
    <?php foreach ($columns as $column => $options): ?>
        <th>
            <?= $options['header'] ?>
        </th>
    <?php endforeach ?>

    <?php if ($buttons): ?>
        <th>&nbsp;</th>
    <?php endif ?>
</tr>
</thead>