<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Floor Heating Web</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="lib/bootstrap.min.css">
</head>
<body>
<?php
require_once 'src/FloorHeatingManager.php';
$floorHeatingManager = new FloorHeatingManager();
$floorHeatingDataRows = $floorHeatingManager->getCurrentFloatingInfo();
?>

<em class="m-1">Последно обновена <span id="last-updated"><?php echo date('H:i:s') ?></span></em>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Стая</th>
        <th scope="col">Текуща темперетура</th>
        <th scope="col">Настройка темперетура</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($floorHeatingDataRows as $row): ?>
            <tr id="<?php echo $row['id'] ?>">
                <td><?php echo $row['name'] ?></td>
                <td>
                    <span class="current-floor-temp"><?php echo $row['current_floor_temp'] ?></span>

                    <span class="is-open <?php if ($row['is_open']) { ?>bg-success <?php } else { ?> bg-danger <?php } ?> p-1 rounded text-white">
                        <?php if ($row['is_open']): ?>
                            Open
                        <?php else: ?>
                            Close
                        <?php endif; ?>
                    </span>
                </td>
                <td>
                    <div class="qty">
                        <span class="control minus bg-danger">-</span>
                        <input type="number" class="floor-temp-set count" name="qty" min="16" max="30" value="<?php echo $row['floor_temp_set'] ?>" disabled="true">
                        <span class="control plus bg-success">+</span>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script src="lib/jquery-3.6.0.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
