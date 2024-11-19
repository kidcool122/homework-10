<?php

namespace app\controllers;

use app\models\Post;

class PostController
{
    public function validatePost($inputData) {
        $errors = [];
        $title = $inputData['title'];
        $content = $inputData['content'];

        if (!$title || strlen($title) < 2) {
            $errors['title'] = 'Title is required and must be at least 2 characters';
        }

        if (!$content || strlen($content) < 5) {
            $errors['content'] = 'Content is required and must be at least 5 characters';
        }

        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        return [
            'title' => htmlspecialchars($title, ENT_QUOTES|ENT_HTML5, 'UTF-8', true),
            'content' => htmlspecialchars($content, ENT_QUOTES|ENT_HTML5, 'UTF-8', true)
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
        echo json_encode($post);
        exit();
    }

    public function savePost() {
        $inputData = json_decode(file_get_contents('php://input'), true);
        $postData = $this->validatePost($inputData);

        $post = new Post();
        $post->savePost([
            'title' => $postData['title'],
            'content' => $postData['content']
        ]);

        http_response_code(201);
        echo json_encode(['success' => true]);
        exit();
    }

    public function updatePost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        parse_str(file_get_contents('php://input'), $_PUT);

        $inputData = [
            'id' => $id,
            'title' => $_PUT['title'] ?? null,
            'content' => $_PUT['content'] ?? null,
        ];

        $postData = $this->validatePost($inputData);

        $post = new Post();
        $post->updatePost($postData);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function deletePost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        $post = new Post();
        $post->deletePost(['id' => $id]);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function postsView() {
        include '../public/assets/views/post/posts-view.html';
        exit();
    }

    public function postsAddView() {
        include '../public/assets/views/post/posts-add.html';
        exit();
    }

    public function postsUpdateView() {
        include '../public/assets/views/post/posts-update.html';
        exit();
    }

    public function postsDeleteView() {
        include '../public/assets/views/post/posts-delete.html';
        exit();
    }
}
