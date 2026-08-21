<?php

return [
    'users' => [
        [
            'username' => env('ADMIN_USER', 'admin'),
            'password' => env('ADMIN_PASSWORD', 'password_por_defecto'),
        ],
        // Si necesitas más usuarios, puedes añadir más variables de entorno
    ],
];