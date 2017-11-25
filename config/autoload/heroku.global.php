<?php
declare(strict_types=1);

if (!getenv('HEROKU')) {
    return [];
}

return [
    'debug' => false,
    'config_cache_enabled' => false,
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => \getenv('DATABASE_URL'),
                ],
            ],
        ],
    ],
    'phph-site' => [
        'google-recaptcha' => [
            'site-key' => \getenv('GOOGLE_RECAPTCHA_SITE_KEY'),
            'secret-key' => \getenv('GOOGLE_RECAPTCHA_SECRET_KEY'),
        ],
        'twitter' => [
            'identifier' => \getenv('TWITTER_IDENTIFIER'),
            'secret' => \getenv('TWITTER_SECRET'),
            'callback_uri' => \getenv('TWITTER_CALLBACK_URL'),
        ],
        'github' => [
            'clientId' => \getenv('GITHUB_CLIENT_ID'),
            'clientSecret' => \getenv('GITHUB_CLIENT_SECRET'),
            'redirectUri' => \getenv('GITHUB_REDIRECT_URI'),
        ],
    ],
];
