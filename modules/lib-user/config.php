<?php

return [
    '__name' => 'lib-user',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-user.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-user' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => [
            [
                'lib-user-main' => NULL
            ],
            [
                'lib-user-auth-cookie' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibUser\\Iface' => [
                'type' => 'file',
                'base' => 'modules/lib-user/interface'
            ],
            'LibUser\\Service' => [
                'type' => 'file',
                'base' => 'modules/lib-user/service'
            ]
        ],
        'files' => []
    ],
    'libUser' => [
        'handler' => NULL,
        'authorizers' => []
    ],
    'service' => [
        'user' => 'LibUser\\Service\\User'
    ]
];