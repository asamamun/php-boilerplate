<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Users</h1>
    <?php foreach ($users as $user): ?>
        <div class="user">
            <h3><?= htmlspecialchars($user['name']) ?></h3>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>