<?php

return [
    '__name' => 'lib-user',
    '__version' => '0.0.4',
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
        'required' => [
            [
                'lib-enum' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-user-main' => NULL
            ],
            [
                'lib-user-auth-cookie' => NULL,
                'lib-user-auth-basic'  => NULL,
                'lib-user-auth-oauth'  => NULL,
                'lib-user-auth-oauth2' => NULL,
                'lib-user-auth-jwt'    => NULL
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
            ],
            'LibUser\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-user/library'
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
    ],
    'libEnum' => [
        'enums' => [
            'user.status' => [
                'Deleted',
                'Suspended',
                'Unverified',
                'Verified'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'user' => [
                'id' => [
                    'type' => 'number'
                ],
                'name' => [
                    'type' => 'text'
                ],
                'fullname' => [
                    'type' => 'text'
                ],
                'password' => [
                    'type' => 'delete'
                ],
                'status' => [
                    'type' => 'enum',
                    'enum' => 'user.status'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ]
        ]
    ]
];