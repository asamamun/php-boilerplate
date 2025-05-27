

<div class="container">
    <h1>Users</h1>
    <a href="users/create" class="btn btn-primary mb-3">Create New User</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Active</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['phone']) ?></td>
                <td><?= htmlspecialchars($user['active']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td><?= htmlspecialchars($user['created']) ?></td>
                <td>
                    <a href="users/<?= $user['id'] ?>" class="btn btn-sm btn-info">View</a>
                    <a href="users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                    <form action="users/<?= $user['id'] ?>/delete" method="POST" style="display: inline;">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

