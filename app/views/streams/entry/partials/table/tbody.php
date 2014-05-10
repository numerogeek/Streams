<tbody>
<?php foreach ($entries as $entry): ?>
    <tr>
        <?php foreach ($columns as $column): ?>
            <td>
                <?= $entry->{$column} ?>
            </td>
        <?php endforeach ?>
    </tr>
<?php endforeach ?>
</tbody>