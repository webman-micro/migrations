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
            "host" => getenv("DB_HOST", 3306),
            "name" => getenv("DB_NAME", ''),
            "user" => getenv("DB_USER", ''),
            "pass" => getenv("DB_PASSWORD", ''),
            "port" => getenv("DB_PORT", ''),
            "charset" => "utf8"
        ]
    ]
];
