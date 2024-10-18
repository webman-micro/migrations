<?php
return [
    'enable' => true,
    "paths" => [
        "migrations" => "database/migrations",
        "seeds" => "database/seeders"
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_environment" => "product",
        "product" => [
            "adapter" => "mysql",
            "host" => getenv("DB_HOST", '127.0.0.1'),
            "name" => getenv("DB_NAME", ''),
            "user" => getenv("DB_USER", ''),
            "pass" => getenv("DB_PASSWORD", ''),
            "port" => getenv("DB_PORT", '3306'),
            "charset" => "utf8"
        ]
    ]
];
