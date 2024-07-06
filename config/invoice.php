<?php

return [
    'node_binary' => env('NODE_BINARY', 'node'),
    'default_theme'=> 'css/invoice-clean.php',

    'logo' => 'https://jordheyeshair.co.uk/images/graphics/logo.webp',
    'title' => 'INVOICE',
    'invoice_number' => 'INV-0001',
    'date' => now()->toDateString(), // This will dynamically set the current date
    'from' => [
        'name' => 'Jord Heyes Hair',
        'phone' => '0987654321',
        'email' => 'email@company.com',
        'address_line_1' => '1234 Street Name',
        'address_line_2' => 'Suite 567',
        'address_line_3' => 'City, State, ZIP',
    ],
    'to' => [
        'name' => 'Jane Doe',
        'phone' => '0987654321',
        'email' => 'customer@domain.com',
        'address_line_1' => '5678 Client St',
        'address_line_2' => 'Apt 910',
        'address_line_3' => 'Client City, State, ZIP',
    ],
    'description' => 'Invoice for services rendered',
    'payment_terms' => 'Payment is due within 30 days.',
    'payment_details' => 'Account Number/Sort Code: 12345678 / 12-34-56',
    'footer' => 'Thank you for your business!',
    'is_paid' => false,
];

