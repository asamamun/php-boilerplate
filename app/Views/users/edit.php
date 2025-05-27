<?php include '../partials/header.php'; ?>

<div class="container">
    <h1>Edit User</h1>
    
    <form action="/users/<?= $user['id'] ?>/update" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                   id="username" name="username" value="<?= $user['username'] ?>">
            <?php if (isset($errors['username'])): ?>
                <div class="invalid-feedback"><?= $errors['username'] ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                   id="email" name="email" value="<?= $user['email'] ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="invalid-feedback"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="password">New Password (leave blank to keep current)</label>
            <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                   id="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <div class="invalid-feedback"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>
        
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="/users/<?= $user['id'] ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../partials/footer.php'; ?>