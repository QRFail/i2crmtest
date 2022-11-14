<html>
<body>
<h1>Последние обновленные репозитории</h1>
<table>
    <tr>
        <td>Названиу репозитория</td>
        <td>Дата обновления</td>
    </tr>
    <?php
    foreach ($data as $item) {
    ?>
        <tr>
            <td><?php echo($item['repository_fullname']) ?></td>
            <td><?php echo($item['repository_pushed_at']) ?></td>
        </tr>
    <?php
    }
?>
</table>
</body>
</html>