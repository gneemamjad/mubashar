<?php

const REQUEST_SMS_TIME_OUT = 10;
const PAGINITION_PER_PAGE = 20;

const MEDIA_TYPES = [
    "image" => "1",
    "vedio" => "2",
    "360image" => "3"
];

const SORTS = [
    "ar" => [
        [
            "key" => 1,
            "title" => "الأفضل"
        ],
        [
            "key" => 2,
            "title" => "السعر من الأغلى إلى الأرخص"
        ],
        [
            "key" => 3,
            "title" =>  "السعر من الأرخص إلى الأغلى"
        ],
         [
            "key" => 4,
            "title" => "من الأقدم إلى الأحدث"
        ],
        [
            "key" => 5,
            "title" => "من الأحدث إلى الأقدم"
        ],
        [
            "key" => 6,
            "title" => " ا الى ي"
        ],
        [
            "key" => 7,
            "title" =>  "ي الى ا"
        ]
    ],
    "en" => [

        [
            "key" => 1,
            "title" =>  "Best match"
        ],
        [
            "key" => 2,
            "title" => "Decreasing by price"
        ],
        [
            "key" => 3,
            "title" =>  "Increasing by price"
        ],
         [
            "key" => 4,
            "title" => "Ascending by date"
        ],
        [
            "key" => 5,
            "title" => "Descending by date"
        ],
        [
            "key" => 6,
            "title" => "A to Z"
        ],
        [
            "key" => 7,
            "title" =>  "Z to A"
        ]

    ]
];


const APP_VERSION = "1.0.1";
const SOFT_UPDATE_VERSIONS=[
    '1.0.0'
];
const FORCE_UPDATE_VERSIONS=[
     '1.0.0'
];
