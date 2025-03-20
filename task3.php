<?php
function connect_to_database()
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'task3';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password, $options);
        return $pdo;

    } catch (PDOException $e) {
        return false;
    }
}

function add_comment($comment)
{
    $pdo = connect_to_database();
    $sql = "INSERT INTO comments (comment) VALUES (:comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['comment' => htmlspecialchars($comment, ENT_QUOTES, 'UTF-8')]);
}


function get_comments()
{
    $pdo = connect_to_database();
    $sql = "SELECT comment FROM comments ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment'])) {
    add_comment(trim($_POST['comment']));
}

$comments = get_comments();
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
<div class="container mt-5">
    <h1 class="text-center mb-4">Комментарии</h1>
    <div class="card shadow-sm p-4">
        <form method="post">
            <div class="mb-3">
                <label for="comment" class="form-label">Оставьте свой комментарий</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Введите текст..." required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Опубликовать</button>
            </div>
        </form>
    </div>
</div>

<div class="container mt-4">
    <?php if($comments): ?>
        <div class="list-group">
            <?php foreach ($comments as $comment): ?>
                <div class="list-group-item"><?= $comment['comment'] ?></div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">Пока нет комментариев. Будьте первым!</div>
    <?php endif; ?>
</div>
</body>
</html>
