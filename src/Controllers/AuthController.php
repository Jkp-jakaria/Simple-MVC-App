<?php
declare(strict_types=1);

namespace App\Controllers;

use PDO;
use App\Models\User;
use App\Core\Validator;

class AuthController
{
    private PDO $db;
    private array $config;

    public function __construct(PDO $db, array $config)
    {
        $this->db = $db;
        $this->config = $config;
    }

    public function showLoginForm(): void
    {
        $this->render('auth/login', ['title' => 'Login']);
    }

    public function showSignupForm(): void
    {
        $this->render('auth/signup', ['title' => 'Signup']);
    }

    public function signup(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if ($name === '') {
            $errors[] = 'Name is required.';
        }

        if (!Validator::isEmail($email)) {
            $errors[] = 'Valid email is required.';
        }

        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        $userModel = new User($this->db);
        if ($userModel->findByEmail($email)) {
            $errors[] = 'Email already exists.';
        }

        if (!empty($errors)) {
            $this->render('auth/signup', [
                'title' => 'Signup',
                'errors' => $errors,
                'old' => ['name' => $name, 'email' => $email]
            ]);
            return;
        }

        $userModel->create($name, $email, $password);

        header('Location: ?route=auth/login');
        exit;
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (!Validator::isEmail($email)) {
            $errors[] = 'Valid email is required.';
        }

        if ($password === '') {
            $errors[] = 'Password is required.';
        }

        $userModel = new User($this->db);
        $user = $userModel->findByEmail($email);

        if (!$user || !$user->verifyPassword($password)) {
            $errors[] = 'Invalid credentials.';
        }

        if (!empty($errors)) {
            $this->render('auth/login', [
                'title' => 'Login',
                'errors' => $errors,
                'old' => ['email' => $email]
            ]);
            return;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;

        header('Location: ?route=submission/form');
        exit;
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ?route=auth/login');
        exit;
    }

    private function render(string $view, array $params = []): void
    {
        extract($params);
        $baseUrl = $this->config['app']['base_url'];
        $viewFile = $view;
        include __DIR__ . '/../Views/layout.php';
    }
}
