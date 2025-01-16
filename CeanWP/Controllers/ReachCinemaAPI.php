<?php

namespace CeanWP\Controllers;

use CeanWP\Libs\APIHelper;

class ReachCinemaAPI extends  APIHelper
{

    const HOST = 'https://filmx-api.reachcinema.io/api/v1';
    protected static string $name = 'ReachCinemaAPI';

    const ENDPOINTS = [
        'coming-soon' => [
            'route' => '/Films/ComingSoon',
            'method' => 'GET',
            // in mins
            'cache' => [self::class, 'validate_coming_soon_good_for_cache'],
            'params' => [
                'page' => null,
                'perPage' => null
            ]
        ],
        'movie' => [
            'route' => '/Films/{{film_id}}',
            'method' => 'GET',
            // in mins
            'cache' => 15,
            'params' => [
                'film_id'
            ]
        ],
//        'coin-info' => [
//            'route' => '/coins/{{coin_id}}',
//            'method' => 'GET',
//            'cache' => 1440, // in minutes for 24 hours
//            'params' => [
//                'localization' => 'false',
//                'tickers' => 'false',
//                'market_data' => 'true',
//                'community_data' => 'true',
//                'developer_data' => 'false',
//                'sparkline' => 'false'
//            ],
//            'substitutions' => [
//                'coin_id'
//            ]
//        ],

    ];

    static function getName(): string
    {
        return static::$name;
    }

    static function get_api_key(): string
    {
        return Settings::get('reach_api_key');
    }

    static function get_headers(): array
    {
        return [
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . self::get_api_key()
        ];
    }

//    static function get_coin_info($coin_id, $setting = []): array {
//        try {
//            return self::make_request('coin-info', [], [
//                'coin_id' => $coin_id
//            ]);
//        } catch (\Exception $e) {
//            return [
//                'error' => $e->getMessage(),
//                'code' => $e->getCode(),
//                'data' => [
//                    'coin_id' => $coin_id,
//                    'setting' => $setting
//                ]
//            ];
//        }
//    }


    static function get_coming_soon_movies(): array
    {
        try {
            return self::make_request('coming-soon');
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    static function get_movie($film_id): array
    {
        try {
            return self::make_request('movie', [], [
                'film_id' => $film_id
            ]);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    static function validate_coming_soon_good_for_cache($d): bool|int
    {
        return isset($d['statusText']) && $d['statusText'] === 'OK' ? 2 * 60 : false;
    }
}