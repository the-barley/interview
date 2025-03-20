<?php
$data = [
    ['Иванов', 'Математика', 5],
    ['Иванов', 'Математика', 4],
    ['Иванов', 'Математика', 5],
    ['Петров', 'Математика', 5],
    ['Сидоров', 'Физика', 4],
    ['Иванов', 'Физика', 4],
    ['Петров', 'ОБЖ', 4],
];

$names = array_unique(array_column($data, 0));
sort($names);
$subjects = array_unique(array_column($data, 1));
sort($subjects);

$results = array_fill_keys($names, array_fill_keys($subjects, 0));

foreach ($data as $item) {
    $results[$item[0]][$item[1]] += $item[2];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="assets/css/bs.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="container">
    <table>
        <thead>
        <tr>
            <th class="text-center" scope="col"></th>
            <?php foreach ($subjects as $subject): ?>
                <th class="text-center" scope="col"><?= htmlspecialchars($subject) ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($results as $name => $ratings): ?>
            <tr>
                <td class="text-center"><?= htmlspecialchars($name) ?></td>
                <?php foreach ($ratings as $subject => $rating):?>
                    <td class="text-center"><?= $rating ?: ''?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>