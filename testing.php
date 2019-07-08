<?php

require __DIR__.'/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_url' => 'http://localhost:8000',
    'defaults' => [
        'verify' => false
    ]
]);

$nickname = 'Project'.rand(0, 999);

// 1) Create a programmer resource
$response = $client->post('/api/projects', [
    'body' => json_encode($data)
]);

// 2) GET a programmer resource
$response = $client->get('/api/projects/'.$nickname);

echo $response;
echo "\n\n";