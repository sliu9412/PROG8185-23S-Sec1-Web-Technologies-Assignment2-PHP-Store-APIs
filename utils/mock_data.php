<?php
$mock_users = [
    [
        "username" => "user1",
        "password" => password_hash("1234", PASSWORD_DEFAULT),
        "province" => "Ontario",
        "city" => "Waterloo",
        "zipcode" => "N2J 2W2",
        "email" => "example1@mail.com",
    ],
    [
        "username" => "user2",
        "password" => password_hash("1234", PASSWORD_DEFAULT),
        "province" => "Ontario",
        "city" => "Waterloo",
        "zipcode" => "N2J 2W2",
        "email" => "example2@mail.com",
    ],
    [
        "username" => "user3",
        "password" => password_hash("1234", PASSWORD_DEFAULT),
        "province" => "Ontario",
        "city" => "Waterloo",
        "zipcode" => "N2J 2W2",
        "email" => "example3@mail.com",
    ],
    [
        "username" => "user4",
        "password" => password_hash("1234", PASSWORD_DEFAULT),
        "province" => "Ontario",
        "city" => "Waterloo",
        "zipcode" => "N2J 2W2",
        "email" => "example4@mail.com",
    ],
    [
        "username" => "user5",
        "password" => password_hash("1234", PASSWORD_DEFAULT),
        "province" => "Ontario",
        "city" => "Waterloo",
        "zipcode" => "N2J 2W2",
        "email" => "example5@mail.com",
    ]
];

$mock_products = [
    [
        "name" => "Nikon DSLR",
        "price" => 1510.0,
        "img" => "images/NikonDSLR.jpg",
        "shipping_cost" => 2.0,
        "description" => "This is a description of this product"
    ],
    [
        "name" => "Cannon DSLR",
        "price" => 999.0,
        "img" => "images/CannonDSLR.jpg",
        "shipping_cost" => 2.0,
        "description" => "This is a description of this product"
    ],
    [
        "name" => "Sony DSLR",
        "price" => 499.0,
        "img" => "images/SONYDSLR.jpg",
        "shipping_cost" => 2.0,
        "description" => "This is a description of this product"
    ],
    [
        "name" => "Cannon 28mm Lens",
        "price" => 150.0,
        "img" => "images/28mm.jpg",
        "shipping_cost" => 2.0,
        "description" => "This is a description of this product"
    ],
    [
        "name" => "Nikon 50mm Lens",
        "price" => 200.0,
        "img" => "images/50mm.jpg",
        "shipping_cost" => 2.0,
        "description" => "This is a description of this product"
    ],
    [
        "name" => "Sony 28mm Lens",
        "price" => 150.0,
        "img" => "images/28mm.jpg",
        "shipping_cost" => 2.0,
        "description" => "This is a description of this product"
    ],
];
