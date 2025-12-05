<?php
declare (strict_types = 1);

use App\Controllers\AuthController;
use App\Controllers\ReportController;
use App\Controllers\SubmissionController;
use App\Core\Database;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$config = require __DIR__ . '/../config/config.php';
date_default_timezone_set($config['app']['timezone']);

$db = Database::getConnection($config);

$route  = $_GET['route'] ?? 'auth/login';
$method = $_SERVER['REQUEST_METHOD'];

switch ($route) {
    case 'auth/login':
        $controller = new AuthController($db, $config);
        if ($method === 'POST') {
            $controller->login();
        } else {
            $controller->showLoginForm();
        }
        break;

    case 'auth/signup':
        $controller = new AuthController($db, $config);
        if ($method === 'POST') {
            $controller->signup();
        } else {
            $controller->showSignupForm();
        }
        break;

    case 'auth/logout':
        $controller = new AuthController($db, $config);
        $controller->logout();
        break;

    case 'submission/form':
        $controller = new SubmissionController($db, $config);
        $controller->requireLogin();
        $controller->showForm();
        break;

    case 'submission/store':
        $controller = new SubmissionController($db, $config);
        $controller->requireLogin();
        if ($method === 'POST') {
            $controller->storeAjax();
        }
        break;

    case 'report/index':
        $controller = new ReportController($db, $config);
        $controller->requireLogin();
        $controller->index();
        break;

    case 'submission/edit':
        $controller = new SubmissionController($db, $config);
        $controller->edit();
        break;

    case 'submission/update':
        $controller = new SubmissionController($db, $config);
        if ($method === 'POST') {
            $controller->update();
        }
        break;

    case 'submission/delete':
        $controller = new SubmissionController($db, $config);
        if ($method === 'POST') {
            $controller->delete();
        }
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
}
