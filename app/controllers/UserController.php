<?php

namespace app\controllers;

use app\models\User;

class UserController
{
    // Validate user input
    public function validateUser($inputData) {
        $errors = [];
        $firstName = $inputData['firstName'];
        $lastName = $inputData['lastName'];

        // First name validation
        if ($firstName) {
            $firstName = htmlspecialchars($firstName, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($firstName) < 2) {
                $errors['firstNameShort'] = 'First name is too short';
            }
        } else {
            $errors['requiredFirstName'] = 'First name is required';
        }

        // Last name validation
        if ($lastName) {
            $lastName = htmlspecialchars($lastName, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($lastName) < 2) {
                $errors['lastNameShort'] = 'Last name is too short';
            }
        } else {
            $errors['requiredLastName'] = 'Last name is required';
        }

        // If errors exist, return them with a 400 HTTP code
        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
        ];
    }

    // Get all users
    public function getAllUsers() {
        $userModel = new User();
        header("Content-Type: application/json");
        $users = $userModel->getAllUsers();
        echo json_encode($users);
        exit();
    }

    // Get a single user by ID
    public function getUserByID($id) {
        $userModel = new User();
        header("Content-Type: application/json");
        $user = $userModel->getUserById($id);
        echo json_encode($user);
        exit();
    }

    // Save a new user
    public function saveUser() {
        $inputData = [
            'firstName' => $_POST['firstName'] ?? false,
            'lastName' => $_POST['lastName'] ?? false,
        ];
        $userData = $this->validateUser($inputData);

        $user = new User();
        $user->saveUser([
            'firstName' => $userData['firstName'],
            'lastName' => $userData['lastName'],
        ]);

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    // Update an existing user
    public function updateUser($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        // Handle PUT data
        parse_str(file_get_contents('php://input'), $_PUT);

        $inputData = [
            'firstName' => $_PUT['firstName'] ?? false,
            'lastName' => $_PUT['lastName'] ?? false,
        ];
        $userData = $this->validateUser($inputData);

        $user = new User();
        $user->updateUser([
            'id' => $id,
            'firstName' => $userData['firstName'],
            'lastName' => $userData['lastName'],
        ]);

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    // Delete a user
    public function deleteUser($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        $user = new User();
        $user->deleteUser(['id' => $id]);

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    // Display the users view
    public function usersView() {
        include '../public/assets/views/user/users-view.html';
        exit();
    }

    // Display the add user view
    public function usersAddView() {
        include '../public/assets/views/user/users-add.html';
        exit();
    }

    // Display the delete user view
    public function usersDeleteView() {
        include '../public/assets/views/user/users-delete.html';
        exit();
    }

    // Display the update user view
    public function usersUpdateView() {
        include '../public/assets/views/user/users-update.html';
        exit();
    }
}
