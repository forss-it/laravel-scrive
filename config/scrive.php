<?php
    return [
        'secret_client_identifier' => env('SCRIVE_CLIENT_IDENTIFIER', null),
        'secret_client_secret' => env('SCRIVE_CLIENT_SECRET', null),
        'secret_token_identifier' => env('SCRIVE_TOKEN_IDENTIFIER', null),
        'secret_token_secret' => env('SCRIVE_TOKEN_SECRET', null),
        'developer_mode' => false,
    ];