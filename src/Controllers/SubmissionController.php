<?php
declare (strict_types = 1);

namespace App\Controllers;

use App\Core\Validator;
use App\Models\Submission;
use PDO;

class SubmissionController
{
    private PDO $db;
    private array $config;

    public function __construct(PDO $db, array $config)
    {
        $this->db     = $db;
        $this->config = $config;
    }

    public function requireLogin(): void
    {
        if (! isset($_SESSION['user_id'])) {
            header('Location: ?route=auth/login');
            exit;
        }
    }

    public function showForm(): void
    {
        $this->render('submission/form', ['title' => 'Data Submission']);
    }

    public function storeAjax(): void
    {
        header('Content-Type: application/json');

        if (isset($_COOKIE['last_submission_time'])) {
            $last = (int) $_COOKIE['last_submission_time'];
            if (time() - $last < 86400) {
                echo json_encode([
                    'success' => false,
                    'errors'  => ['You can only submit once every 24 hours.'],
                ]);
                return;
            }
        }

        $amount     = trim($_POST['amount'] ?? '');
        $buyer      = trim($_POST['buyer'] ?? '');
        $receiptId  = trim($_POST['receipt_id'] ?? '');
        $itemsArray = $_POST['items'] ?? [];
        $buyerEmail = trim($_POST['buyer_email'] ?? '');
        $note       = trim($_POST['note'] ?? '');
        $city       = trim($_POST['city'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');
        $entryBy    = trim($_POST['entry_by'] ?? '');

        $errors = [];

        if (! Validator::isNumeric($amount)) {
            $errors[] = 'Amount must be numeric.';
        }

        if (! Validator::isTextWithSpacesNumbers($buyer, 20)) {
            $errors[] = 'Buyer: only letters, numbers, spaces, max 20 chars.';
        }

        if ($receiptId === '') {
            $errors[] = 'Receipt ID is required.';
        }

        if (empty($itemsArray)) {
            $errors[] = 'At least one item is required.';
        }

        $items = implode(', ', array_map('trim', $itemsArray));

        if (! Validator::isEmail($buyerEmail)) {
            $errors[] = 'Valid buyer email is required.';
        }

        if (! Validator::maxWords($note, 30)) {
            $errors[] = 'Note must not exceed 30 words.';
        }

        if (! Validator::isTextWithSpaces($city)) {
            $errors[] = 'City: only letters and spaces.';
        }

        if (! Validator::isNumeric($phone)) {
            $errors[] = 'Phone must be numeric.';
        }

        if (! Validator::isNumeric($entryBy)) {
            $errors[] = 'Entry_by must be numeric.';
        }

        if (! empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        $buyerIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        $hashKey = hash('sha512', $receiptId . $this->config['app']['hash_salt']);
        $entryAt = date('Y-m-d');

        $submissionModel = new Submission($this->db);

        $success = $submissionModel->create([
            'amount'      => (int) $amount,
            'buyer'       => $buyer,
            'receipt_id'  => $receiptId,
            'items'       => $items,
            'buyer_email' => $buyerEmail,
            'buyer_ip'    => $buyerIp,
            'note'        => $note,
            'city'        => $city,
            'phone'       => $phone,
            'hash_key'    => $hashKey,
            'entry_at'    => $entryAt,
            'entry_by'    => (int) $entryBy,
        ]);

        if ($success) {
            setcookie('last_submission_time', (string) time(), time() + 86400, '/');

            echo json_encode(['success' => true, 'message' => 'Submission saved successfully.']);
        } else {
            echo json_encode(['success' => false, 'errors' => ['Database error.']]);
        }
    }

    private function render(string $view, array $params = []): void
    {
        extract($params);
        $baseUrl  = $this->config['app']['base_url'];
        $viewFile = $view;
        include __DIR__ . '/../Views/layout.php';
    }

    public function edit(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: ?route=report/index');
            exit;
        }

        $submissionModel = new Submission($this->db);
        $submission      = $submissionModel->find($id);

        if (! $submission) {
            header('Location: ?route=report/index');
            exit;
        }

        $this->render('submission/edit', [
            'title'      => 'Edit Submission',
            'submission' => $submission,
            'errors'     => [],
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: ?route=report/index');
            exit;
        }

        $amount     = trim($_POST['amount'] ?? '');
        $buyer      = trim($_POST['buyer'] ?? '');
        $receiptId  = trim($_POST['receipt_id'] ?? '');
        $itemsArray = $_POST['items'] ?? [];
        $buyerEmail = trim($_POST['buyer_email'] ?? '');
        $note       = trim($_POST['note'] ?? '');
        $city       = trim($_POST['city'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');
        $entryBy    = trim($_POST['entry_by'] ?? '');

        $errors = [];

        if (! Validator::isNumeric($amount)) {
            $errors[] = 'Amount must be numeric.';
        }

        if (! Validator::isTextWithSpacesNumbers($buyer, 20)) {
            $errors[] = 'Buyer: only letters, numbers, spaces, max 20 chars.';
        }

        if ($receiptId === '') {
            $errors[] = 'Receipt ID is required.';
        }

        if (empty($itemsArray)) {
            $errors[] = 'At least one item is required.';
        }

        $items = implode(', ', array_map('trim', $itemsArray));

        if (! Validator::isEmail($buyerEmail)) {
            $errors[] = 'Valid buyer email is required.';
        }

        if (! Validator::maxWords($note, 30)) {
            $errors[] = 'Note must not exceed 30 words.';
        }

        if (! Validator::isTextWithSpaces($city)) {
            $errors[] = 'City: only letters and spaces.';
        }

        if (! Validator::isNumeric($phone)) {
            $errors[] = 'Phone must be numeric.';
        }

        if (! Validator::isNumeric($entryBy)) {
            $errors[] = 'Entry_by must be numeric.';
        }

        $submissionModel = new Submission($this->db);
        $existing        = $submissionModel->find($id);

        if (! $existing) {
            header('Location: ?route=report/index');
            exit;
        }

        if (! empty($errors)) {
            $existing['amount']      = $amount;
            $existing['buyer']       = $buyer;
            $existing['receipt_id']  = $receiptId;
            $existing['items']       = $items;
            $existing['buyer_email'] = $buyerEmail;
            $existing['note']        = $note;
            $existing['city']        = $city;
            $existing['phone']       = $phone;
            $existing['entry_by']    = $entryBy;

            $this->render('submission/edit', [
                'title'      => 'Edit Submission',
                'submission' => $existing,
                'errors'     => $errors,
            ]);
            return;
        }

        $buyerIp = $existing['buyer_ip']; // keep original IP
        $hashKey = hash('sha512', $receiptId . $this->config['app']['hash_salt']);
        $entryAt = $existing['entry_at']; // keep original date

        $success = $submissionModel->update($id, [
            'amount'      => (int) $amount,
            'buyer'       => $buyer,
            'receipt_id'  => $receiptId,
            'items'       => $items,
            'buyer_email' => $buyerEmail,
            'buyer_ip'    => $buyerIp,
            'note'        => $note,
            'city'        => $city,
            'phone'       => $phone,
            'hash_key'    => $hashKey,
            'entry_at'    => $entryAt,
            'entry_by'    => (int) $entryBy,
        ]);

        header('Location: ?route=report/index');
        exit;
    }

    public function delete(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=report/index');
            exit;
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id <= 0) {
            header('Location: ?route=report/index');
            exit;
        }

        $submissionModel = new Submission($this->db);
        $submissionModel->delete($id);

        header('Location: ?route=report/index');
        exit;
    }

}
