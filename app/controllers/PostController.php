<?php

namespace app\controllers;

use app\models\Post;

class PostController {

    public function getAllPosts() {
        $postModel = new Post();
        header("Content-Type: application/json");
        echo json_encode($postModel->getAllPosts());
    }

    public function savePost() {
        $data = json_decode(file_get_contents('php://input'), true);
        $postModel = new Post();
        $postModel->savePost($data);
        echo json_encode(['success' => true]);
    }

    public function updatePost($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['title']) || !isset($input['content'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Title and content are required']);
            exit();
        }

        $title = $input['title'];
        $content = $input['content'];

        $postData = [
            'id' => $id,
            'title' => $title,
            'content' => $content
        ];

        $postModel = new Post();
        $result = $postModel->updatePost($postData);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update post']);
        }
    }

    public function deletePost($id) {
        $postModel = new Post();
        $postModel->deletePost($id);
        echo json_encode(['success' => true]);
    }

    public function postsView() {
        include "../public/assets/views/user/posts-view.html";
    }

    public function postsAddView() {
        include "../public/assets/views/user/posts-add.html";
    }
}
