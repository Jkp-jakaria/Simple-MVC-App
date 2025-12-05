<?php
declare(strict_types=1);

namespace App\Controllers;

use PDO;
use App\Models\Submission;

class ReportController
{
    private PDO $db;
    private array $config;

    public function __construct(PDO $db, array $config)
    {
        $this->db = $db;
        $this->config = $config;
    }

    public function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?route=auth/login');
            exit;
        }
    }

    public function index(): void
    {
        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;
        $userId = $_GET['user_id'] ?? null;
        $userId = $userId !== '' ? (int) $userId : null;

        $submissionModel = new Submission($this->db);
        $submissions = $submissionModel->getAll(
            $from ?: null,
            $to ?: null,
            $userId ?: null
        );

        $this->render('report/index', [
            'title' => 'Submissions Report',
            'submissions' => $submissions,
            'filters' => [
                'from' => $from,
                'to' => $to,
                'user_id' => $userId
            ]
        ]);
    }

    private function render(string $view, array $params = []): void
    {
        extract($params);
        $baseUrl = $this->config['app']['base_url'];
        $viewFile = $view;
        include __DIR__ . '/../Views/layout.php';
    }
}
