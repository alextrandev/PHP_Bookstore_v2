<?php

$json = file_get_contents('./books.json');
$json_data = json_decode($json, true);

foreach ($json_data as $data) {
    ["title" => $title, "description" => $description, "author" => $author, "publishing_year" => $publishing_year, "genre" => $genre,] = $data;
    include './components/config.php';
    $stmt = $pdo->prepare("INSERT INTO books (title, description, author, publishing_year, genre) VALUES (?,?,?,?,?)");
    $stmt->execute([$title, $description, $author, $publishing_year, $genre]);
}
