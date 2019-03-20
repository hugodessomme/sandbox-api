<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Database
$db = new Database();
$db = $db->connect();


// Post
$post = new Post($db);

// Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$post = $post->read_single();

$post_item = [
    'id' => $post['id'],
    'title' => $post['title'],
    'body' => html_entity_decode($post['body']),
    'author' => $post['author'],
    'category_id' => $post['category_id'],
    'category_name' => $post['category_name'],
];
print_r(json_encode($post_item));