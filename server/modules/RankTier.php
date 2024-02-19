<?php

namespace server\modules;

class RankTier
{
    public static array $rankTier = [
        'D-',
        'D',
        'D+',
        'C-',
        'C',
        'C+',
        'B-',
        'B',
        'B+',
        'A-',
        'A',
        'A+',
        'S-',
        'S',
        'S+'
    ];

    public static array $rankTierMax = [
        "D-" => 70,
        'D' => 100,
        'D+' => 130,
        'C-' => 170,
        'C' => 200,
        'C+' => 230,
        'B-' => 270,
        'B' => 300,
        'B+' => 330,
        'A-' => 370,
        'A' => 400,
        'A+' => 430,
        'S-' => 470,
        'S' => 500,
        'S+' => 530,
    ];
}

?>