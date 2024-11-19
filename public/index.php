<?php
require_once "../app/models/Model.php";
require_once "../app/models/Post.php";
require_once "../app/controllers/PostController.php";

define('DBNAME', 'your_database_name');
define('DBHOST', 'localhost');
define('DBUSER', 'your_database_user');
define('DBPASS', 'your_database_password');

use app\controllers\PostController;

$uri = strtok($_SERVER["REQUEST_URI"], '?');

$uriArray = explode("/", $uri);

if ($uriArray[1] === 'api' && $uriArray[2] === 'posts' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->getAllPosts();
}

if ($uriArray[1] === 'api' && $uriArray[2] === 'posts' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $postController = new PostController();
    $postController->savePost();
}

if ($uriArray[1] === 'api' && $uriArray[2] === 'posts' && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $postController = new PostController();
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
    $postController->updatePost($id);
}

if ($uriArray[1] === 'api' && $uriArray[2] === 'posts' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $postController = new PostController();
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
    $postController->deletePost($id);
}

if ($uriArray[1] === 'posts-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsAddView();
}

if ($uriArray[1] === 'posts-view' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsView();
}

if ($uriArray[1] === 'posts-update' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsUpdateView();
}

if ($uriArray[1] === 'posts-delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $postController = new PostController();
    $postController->postsDeleteView();
}
