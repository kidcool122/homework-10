<?php
require_once "../app/models/Model.php";
require_once "../app/models/Post.php";
require_once "../app/controllers/PostController.php";

// Set environment variables
$env = parse_ini_file('../.env');
define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);
define('DBPORT', $env['DBPORT']);

use app\controllers\PostController;

$uri = strtok($_SERVER["REQUEST_URI"], '?');
$uriArray = explode("/", $uri);

if ($uriArray[1] === 'api' && $uriArray[2] === 'posts') {
    $postController = new PostController();
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET' && !isset($uriArray[3])) {
        $postController->getAllPosts();
    } elseif ($method === 'GET' && isset($uriArray[3])) {
        $postController->getPostByID(intval($uriArray[3]));
    } elseif ($method === 'POST') {
        $postController->savePost();
    } elseif ($method === 'PUT') {
        $postController->updatePost(intval($uriArray[3] ?? null));
    } elseif ($method === 'DELETE') {
        $postController->deletePost(intval($uriArray[3] ?? null));
    }
}

if ($uriArray[1] === 'posts-view') {
    $postController = new PostController();
    $postController->postsView();
}

if ($uriArray[1] === 'posts-add') {
    $postController = new PostController();
    $postController->postsAddView();
}
