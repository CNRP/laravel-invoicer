<?php

return [
    'settings' => [
        'node_binary' => env('NODE_BINARY', 'node'),
        'default_theme' => 'css/invoice-clean.php',
    ],

    'invoice_structure' => [
        'header' => [
            'logo' => [
                'enabled' => true,
                'default' => 'https://jordheyeshair.co.uk/images/graphics/logo.webp',
            ],
            'title' => [
                'enabled' => true,
                'default' => 'INVOICE',
            ],
            'invoice_number' => [
                'enabled' => true,
                'default' => 'INV-0001',
            ],
            'date' => [
                'enabled' => true,
                'default' => null,
            ],
        ],
        'from' => [
            'name' => ['enabled' => true, 'default' => 'Connor Price'],
            'phone' => ['enabled' => true, 'default' => '0987611321'],
            'email' => ['enabled' => true, 'default' => 'email@company.com'],
            'address_line_1' => ['enabled' => true, 'default' => '1234 Street Name'],
            'address_line_2' => ['enabled' => true, 'default' => 'Suite 567'],
            'address_line_3' => ['enabled' => true, 'default' => 'City, State, ZIP'],
        ],
        'to' => [
            'name' => ['enabled' => true, 'default' => ''],
            'phone' => ['enabled' => true, 'default' => ''],
            'email' => ['enabled' => true, 'default' => ''],
            'address_line_1' => ['enabled' => true, 'default' => ''],
            'address_line_2' => ['enabled' => true, 'default' => ''],
            'address_line_3' => ['enabled' => true, 'default' => ''],
        ],
        'details' => [
            'description' => [
                'enabled' => true,
                'default' => 'Invoice for services rendered',
            ],
            'payment_terms' => [
                'enabled' => true,
                'default' => 'Payment is due within 30 days.',
            ],
            'payment_details' => [
                'enabled' => true,
                'default' => 'Account Number:  12345678<br>Sort Code: 12-34-56',
            ],
            'is_paid' => [
                'enabled' => true,
                'default' => false,
            ],
            'footer' => [
                'enabled' => true,
                'default' => 'Thank you for your business!',
            ],
        ],
    ],
];
