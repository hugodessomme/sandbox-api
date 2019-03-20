<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Database
$db = new Database();
$db = $db->connect();


// Posts
$posts = new Post($db);

// Get post and count results
$posts = $posts->read();
$total = count($posts);

if ($total > 0) {
    $posts_arr = [];
    $posts_arr['data'] = [];

    foreach($posts as $post) {
        $post_item = [
            'id' => $post['id'],
            'title' => $post['title'],
            'body' => html_entity_decode($post['body']),
            'author' => $post['author'],
            'category_id' => $post['category_id'],
            'category_name' => $post['category_name'],
        ];

        array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);
} else {
    // No posts
    echo json_encode(
        ['message' => 'No posts found']
    );
}
