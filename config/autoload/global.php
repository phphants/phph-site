<?php
declare(strict_types=1);

return [
    'phph-site' => [
        'meetups-data-path' => __DIR__ . '/../../data/meetups/',
        'speaker-headshot-path' => __DIR__ . '/../../public/images/speakers/',
        'google-recaptcha' => [
            'api-url' => 'https://www.google.com/recaptcha/api/siteverify',
            'site-key' => 'POPULATE THIS',
            'secret-key' => 'POPULATE THIS',
        ],
        'twitter' => [
            'identifier' => 'POPULATE THIS',
            'secret' => 'POPULATE THIS',
            'callback_uri' => 'https://www.phphants.co.uk/account/twitter/callback',
        ],
    ],
];
