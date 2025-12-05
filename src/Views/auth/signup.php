<h1>Signup</h1>

<?php if (!empty($errors)): ?>
    <ul class="error-list">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form id="signup-form" method="post" action="?route=auth/signup" novalidate>
    <label>Name:
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
    </label><br>
    <label>Email:
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
    </label><br>
    <label>Password:
        <input type="password" name="password" required>
    </label><br>
    <button type="submit">Signup</button>
</form>

<script src="js/auth.js"></script>
