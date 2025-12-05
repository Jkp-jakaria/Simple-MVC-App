<?php
    /** @var string $title */
    /** @var string $viewFile */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title ?? 'App')?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="top-bar">
        <div class="brand">
            <span class="brand-logo">💸</span>
            <span class="brand-text">Simple MVC App</span>
        </div>

        <nav>
            <?php if (! empty($_SESSION['user_id'])): ?>
                <a href="?route=submission/form">Submit Data</a>
                <span class="nav-separator">|</span>
                <a href="?route=report/index">Report</a>
                <span class="nav-separator">|</span>
                <a href="?route=auth/logout">
                    Logout (<?php echo htmlspecialchars($_SESSION['user_name'])?>)
                </a>
            <?php else: ?>
                <a href="?route=auth/login">Login</a>
                <span class="nav-separator">|</span>
                <a href="?route=auth/signup">Signup</a>
            <?php endif; ?>
        </nav>

        <div class="theme-toggle-wrapper">
            <input type="checkbox" id="theme-toggle" class="theme-toggle-input">
            <label for="theme-toggle" class="theme-toggle-label">
                <span class="toggle-icon sun">☀</span>
                <span class="toggle-icon moon">🌙</span>
                <span class="toggle-thumb"></span>
            </label>
        </div>
    </div>
</header>

<main>
    <?php
        if (isset($viewFile)) {
            include __DIR__ . '/' . $viewFile . '.php';
        } else {
            echo 'View not specified.';
        }
    ?>
</main>

<script src="js/theme.js"></script>
</body>
</html>
