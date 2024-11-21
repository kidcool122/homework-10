<?php

namespace app\controllers;

use app\models\Post;

class PostController
{
    public function validatePost($inputData) {
        $errors = [];
        $title = $inputData['title'] ?? null;
        $content = $inputData['content'] ?? null;

        if (!$title || strlen($title) < 2) {
            $errors['title'] = 'Title is required and must be at least 2 characters.';
        }

        if (!$content || strlen($content) < 5) {
            $errors['content'] = 'Content is required and must be at least 5 characters.';
        }

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            exit();
        }

        return [
            'title' => htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8', true),
            'content' => htmlspecialchars($content, ENT_QUOTES | ENT_HTML5, 'UTF-8', true),
        ];
    }

    public function getAllPosts() {
        $postModel = new Post();
        header("Content-Type: application/json");
        $posts = $postModel->getAllPosts();
        echo json_encode($posts);
        exit();
    }

    public function getPostByID($id) {
        $postModel = new Post();
        header("Content-Type: application/json");
        $post = $postModel->getPostById($id);

        if (!$post) {
            http_response_code(404);
            echo json_encode(['error' => 'Post not found.']);
            exit();
        }

        echo json_encode($post);
        exit();
    }

    public function savePost() {
        $inputData = json_decode(file_get_contents('php://input'), true);
        if (!$inputData) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input.']);
            exit();
        }

        $postData = $this->validatePost($inputData);

        $post = new Post();
        $post->savePost([
            'title' => $postData['title'],
            'content' => $postData['content'],
        ]);

        http_response_code(201);
        echo json_encode(['success' => true]);
        exit();
    }

    public function updatePost($id) {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Post ID is required.']);
            exit();
        }

        $inputData = json_decode(file_get_contents('php://input'), true);
        if (!$inputData) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input.']);
            exit();
        }

        $inputData['id'] = $id;
        $postData = $this->validatePost($inputData);

        $post = new Post();
        $post->updatePost($postData);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function deletePost($id) {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Post ID is required.']);
            exit();
        }

        $post = new Post();
        $post->deletePost(['id' => $id]);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function postsView() {
        $viewPath = '../public/assets/views/user/posts-view.html';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Error: View file 'posts-view.html' not found.";
        }
        exit();
    }

    public function postsAddView() {
        $viewPath = '../public/assets/views/user/posts-add.html';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Error: View file 'posts-add.html' not found.";
        }
        exit();
    }

    public function postsUpdateView() {
        $viewPath = '../public/assets/views/user/posts-update.html';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Error: View file 'posts-update.html' not found.";
        }
        exit();
    }

    public function postsDeleteView() {
        $viewPath = '../public/assets/views/user/posts-delete.html';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Error: View file 'posts-delete.html' not found.";
        }
        exit();
    }
}
