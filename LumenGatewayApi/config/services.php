<?php

return [
    'authors' => [
        'base_uri' => env('AUTHORS_SERVICE_BASE_URL'),
        'secret' => env('AUTHORS_SERVICE_SECRET'),
    ],

    'books' => [
        'base_uri' => env('BOOKS_SERVICE_BASE_URL'),
        'secret' => env('BOOKS_SERVICE_SECRET'),
    ],

    'comments' => [
        'base_uri' => env('COMMENTS_SERVICE_BASE_URL'),
        'secret' => env('COMMENTS_SERVICE_SECRET'),
    ],
];
