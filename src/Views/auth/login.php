<?php /** @var array|null $errors */ ?>
<h1>Login</h1>

<?php if (!empty($errors)): ?>
    <ul class="error-list">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form id="login-form" method="post" action="?route=auth/login" novalidate>
    <label>Email:
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
    </label><br>
    <label>Password:
        <input type="password" name="password" required>
    </label><br>
    <button type="submit">Login</button>
</form>

<script src="js/auth.js"></script>
