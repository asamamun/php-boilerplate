<!-- app/Views/users/show.php -->
<?php view('partials/header', ['title' => 'User Profile']) ?>

<div class="container">
    <h1>User Details</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($user['name']) ?></h5>
            <p class="card-text">
                <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?><br>
                <strong>Created At:</strong> <?= htmlspecialchars($user['created']) ?>
            </p>
            <a href="<?= $_ENV['APP_URL'] ?>users/<?= $user['id'] ?>/edit" class="btn btn-warning">Edit</a>
            <form action="<?= $_ENV['APP_URL'] ?>users/<?= $user['id'] ?>/delete" method="POST" style="display: inline;">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
    
    <a href="<?= $_ENV['APP_URL'] ?>users" class="btn btn-secondary mt-3">Back to Users</a>
</div>

<?php view('partials/footer') ?>


