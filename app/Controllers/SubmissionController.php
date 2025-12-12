<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Submission;

class SubmissionController extends Controller
{
    private $submissionModel;

    public function __construct()
    {
        Session::start();
        $this->submissionModel = new Submission();
    }

    public function create()
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Method not allowed'], 405);
        }

        // Check cookie for 24-hour submission limit
        $cookieName = 'submission_' . Session::getUserId();
        if (isset($_COOKIE[$cookieName])) {
            $this->jsonResponse([
                'success' => false, 
                'error' => 'You can only submit once per 24 hours'
            ], 429);
        }

        $data = $_POST;
        $errors = $this->validateSubmission($data);

        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'errors' => $errors], 400);
        }
   #hasing is happeing for receipt id
        $config = require __DIR__ . '/../../config/app.php';
        $hashKey = hash('sha512', $data['receipt_id'] . $config['hash_salt']);

        $submissionData = [
            'amount' => (int)$data['amount'],
            'buyer' => $data['buyer'],
            'receipt_id' => $data['receipt_id'],
            'items' => $data['items'],
            'buyer_email' => $data['buyer_email'],
            'buyer_ip' => $this->getClientIp(),
            'note' => $data['note'],
            'city' => $data['city'],
            'phone' => $data['phone'],
            'hash_key' => $hashKey,
            'entry_at' => date('Y-m-d'),
            'entry_by' => Session::getUserId()
        ];

        if ($this->submissionModel->create($submissionData)) {
            // Set cookie for 24 hours
            setcookie($cookieName, '1', time() + (24 * 60 * 60), '/');
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Submission successful'
            ]);
        }

        $this->jsonResponse(['success' => false, 'error' => 'Submission failed'], 500);
    }

    public function index()
    {
        $this->requireAuth();
        // View will be rendered separately
    }

    public function report()
    {
        $this->requireAuth();

        $filters = [
            'start_date' => $_GET['start_date'] ?? '',
            'end_date' => $_GET['end_date'] ?? '',
            'entry_by' => $_GET['entry_by'] ?? ''
        ];

        $submissions = $this->submissionModel->getAll($filters);
        
        if ($this->isAjaxRequest()) {
            $this->jsonResponse(['success' => true, 'data' => $submissions]);
        }

        return $submissions;
    }

    private function validateSubmission($data)
    {
        $errors = [];

        // Amount: only numbers
        if (empty($data['amount'])) {
            $errors['amount'] = 'Amount is required';
        } elseif (!is_numeric($data['amount']) || (int)$data['amount'] <= 0) {
            $errors['amount'] = 'Amount must be a positive number';
        }

        // Buyer: only text, spaces and numbers, not more than 20 characters
        if (empty($data['buyer'])) {
            $errors['buyer'] = 'Buyer is required';
        } elseif (strlen($data['buyer']) > 20) {
            $errors['buyer'] = 'Buyer name must not exceed 20 characters';
        } elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $data['buyer'])) {
            $errors['buyer'] = 'Buyer name can only contain letters, numbers, and spaces';
        }

        // Receipt_id: only text
        if (empty($data['receipt_id'])) {
            $errors['receipt_id'] = 'Receipt ID is required';
        } elseif (strlen($data['receipt_id']) > 20) {
            $errors['receipt_id'] = 'Receipt ID must not exceed 20 characters';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $data['receipt_id'])) {
            $errors['receipt_id'] = 'Receipt ID can only contain letters';
        }

        // Items: only text
        if (empty($data['items'])) {
            $errors['items'] = 'Items are required';
        } elseif (!preg_match('/^[a-zA-Z\s,]+$/', $data['items'])) {
            $errors['items'] = 'Items can only contain letters, spaces, and commas';
        }

        // Buyer_email: only emails
        if (empty($data['buyer_email'])) {
            $errors['buyer_email'] = 'Buyer email is required';
        } elseif (!filter_var($data['buyer_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['buyer_email'] = 'Invalid email format';
        } elseif (strlen($data['buyer_email']) > 50) {
            $errors['buyer_email'] = 'Email must not exceed 50 characters';
        }

        // Note: anything, not more than 30 words, can be unicode
        if (empty($data['note'])) {
            $errors['note'] = 'Note is required';
        } else {
            // Count words including Unicode characters
            $words = preg_split('/\s+/u', trim($data['note']), -1, PREG_SPLIT_NO_EMPTY);
            $wordCount = count($words);
            if ($wordCount > 30) {
                $errors['note'] = 'Note must not exceed 30 words';
            }
        }

        // City: only text and spaces
        if (empty($data['city'])) {
            $errors['city'] = 'City is required';
        } elseif (strlen($data['city']) > 20) {
            $errors['city'] = 'City must not exceed 20 characters';
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $data['city'])) {
            $errors['city'] = 'City can only contain letters and spaces';
        }

        // Phone: only numbers (880 will be prepended by JS)
        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone is required';
        } elseif (!preg_match('/^\d+$/', $data['phone'])) {
            $errors['phone'] = 'Phone can only contain numbers';
        } elseif (strlen($data['phone']) > 20) {
            $errors['phone'] = 'Phone number is too long';
        }

        // Entry_by: only numbers
        if (empty($data['entry_by'])) {
            $errors['entry_by'] = 'Entry by is required';
        } elseif (!is_numeric($data['entry_by']) || (int)$data['entry_by'] <= 0) {
            $errors['entry_by'] = 'Entry by must be a positive number';
        }

        return $errors;
    }
}

