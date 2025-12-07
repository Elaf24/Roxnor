<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        Session::start();
        $this->userModel = new User();
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = $this->validateSignup($name, $email, $password);

        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'errors' => $errors], 400);
        }

        if ($this->userModel->findByEmail($email)) {
            $this->jsonResponse(['success' => false, 'errors' => ['email' => 'Email already exists']], 400);
        }

        if ($this->userModel->create($name, $email, $password)) {
            $this->jsonResponse(['success' => true, 'message' => 'Registration successful']);
        }

        $this->jsonResponse(['success' => false, 'errors' => ['general' => 'Registration failed']], 500);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = $this->validateLogin($email, $password);

        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'errors' => $errors], 400);
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            $this->jsonResponse(['success' => false, 'errors' => ['general' => 'Invalid email or password']], 401);
        }

        Session::set('user_id', $user['id']);
        Session::set('user_name', $user['name']);
        Session::set('user_email', $user['email']);

        $this->jsonResponse(['success' => true, 'message' => 'Login successful']);
    }

    public function logout()
    {
        Session::destroy();
        $this->redirect('/login.php');
    }

    private function validateSignup($name, $email, $password)
    {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Name is required';
        } elseif (strlen($name) > 255) {
            $errors['name'] = 'Name is too long';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        return $errors;
    }

    private function validateLogin($email, $password)
    {
        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }
}

