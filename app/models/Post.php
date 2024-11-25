<?php

namespace app\models;

class Post extends Model {

    public function getAllPosts() {
        $query = "SELECT * FROM posts ORDER BY created_at DESC";
        return $this->fetchAll($query);
    }

    public function savePost($data) {
        $query = "INSERT INTO posts (title, content) VALUES (:title, :content)";
        return $this->execute($query, $data);
    }

    public function updatePost($data) {
        $query = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
        return $this->execute($query, $data);
    }

    public function deletePost($id) {
        $query = "DELETE FROM posts WHERE id = :id";
        return $this->execute($query, ['id' => $id]);
    }
}
