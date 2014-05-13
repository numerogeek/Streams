<tbody>
<?php foreach ($rows as $row): ?>
    <tr <?= $row['row'] ?>>
        <?php foreach ($columns as $column => $options): ?>
            <td <?= $row['column'][$column] ?>>
                <?= $row['data'][$column] ?>
            </td>
        <?php endforeach ?>
    </tr>
<?php endforeach ?>
</tbody>