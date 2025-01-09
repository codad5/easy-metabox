<?php

namespace CeanWP\Libs;

use CeanWP\Controllers\Settings;

abstract class APIHelper
{
    protected static string $name = 'APIHelper';

    const CACHE_PREFIX = 'ceanwp_';
    const CACHE_GROUP = 'ceanwp_api_cache';
    const DEFAULT_CACHE_INTERVAL = 1;
    public static function prepare_request_url($url, $params = []): string {
        $url =  $url . '?' . http_build_query($params);
        return rtrim($url, '?#');
    }


    public static function cache($key, $value, int $expiration = null): bool
    {
        if ($expiration === null) {
            $expiration = Settings::get('cache_interval', self::DEFAULT_CACHE_INTERVAL);
        }
        if(set_transient($key, $value, intval($expiration) * MINUTE_IN_SECONDS)) {
            $previous_cache_key = get_transient( self::CACHE_GROUP ) ?: [];
            $previous_cache_key = array_unique( array_merge( $previous_cache_key, [ $key ] ) );
            set_transient( self::CACHE_GROUP , $previous_cache_key, intval( $expiration ) * MINUTE_IN_SECONDS );
            return true;
        }
        return false;

    }

    public static function clear_cache(): void {
        $cache_keys = get_transient(self::CACHE_GROUP);
        if ($cache_keys) {
            foreach ($cache_keys as $key) {
                delete_transient($key);
            }
        }
        delete_transient(self::CACHE_GROUP);
    }

    public static function list_cache(): array {
        $cache_keys = get_transient(self::CACHE_GROUP);
        $caches = [];
        if ($cache_keys) {
            foreach ($cache_keys as $key) {
                $caches[$key] = get_transient($key);
            }
        }
        return $caches;
    }

    public static function get_cache($key) {
        if(!str_starts_with($key, self::CACHE_PREFIX)) {
            $key = self::CACHE_PREFIX . $key;
        }
        return get_transient($key);
    }


    /**
     * @throws \Exception
     */
    public static function request($method, $url, $params = [], $args = []) {
        $default_args = [
            'method' => strtoupper($method),
            'headers' => [],
            'body' => (strtoupper($method) === 'GET') ? null : $params,
        ];

        // Properly merge headers with default args
        if (isset($args['headers'])) {
            $default_args['headers'] = array_merge($default_args['headers'], $args['headers']);
        }

        $request_args = array_merge($default_args, $args);

        $response = wp_remote_request($url, $request_args);

        if (is_wp_error($response)) {
            throw new \Exception(sprintf(__('Error %s: %s', 'cean-wp-theme'), esc_html($response->get_error_code()), esc_html($response->get_error_message())));
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(sprintf(__('Error %s: %s', 'cean-wp-theme'), json_last_error(), json_last_error_msg()));
        }

        $cache = $args['cache'] ?? true;
        try {
            if (is_callable($cache)) {
                $cache = $cache($data);
            }
        } catch (\Exception $e) {
            $cache = false;
        }

        if ($cache && strtoupper($method) === 'GET') {
            static::cache($url, $data, is_numeric($cache) ? $cache : Settings::get('cache_interval', self::DEFAULT_CACHE_INTERVAL));
        }

        return $data;
    }

    /**
     * @throws \Exception
     */
    static function make_request($name, $params = [], $substitutions = []) {
        $endpoint = static::ENDPOINTS[$name] ?? null;
        if (!$endpoint) {
            throw new \Exception(__('Invalid endpoint name', 'ultimate-crypto-widget'));
        }

        $route = $endpoint['route'] ?? null;
        if (!$route) {
            throw new \Exception(__('Invalid endpoint route', 'ultimate-crypto-widget'));
        }

        $route = static::substitute($route, $substitutions);
        $endpoint_params = $endpoint['params'] ?? [];
        $params = [...$endpoint_params, ...$params];

        // Filter params to match only keys defined in endpoint_params
        $params = array_filter($params, function ($key) use ($endpoint_params) {
            return array_key_exists($key, $endpoint_params);
        }, ARRAY_FILTER_USE_KEY);

        // Check if any params are callable and execute them
        foreach ($params as $key => $value) {
            if (is_callable($value)) {
                $params[$key] = $value();
            }
        }

        // Make the request with the right method, defaulting to GET
        $method = $endpoint['method'] ?? 'GET';
        $url = static::HOST . $route;

        // Add headers to the request args
        $args = array_merge($endpoint, ['headers' => static::get_headers()]);

        if ($method === 'GET') {
            $url = static::prepare_request_url($url, $params);
            $cached_data = static::get_cache($url);
            if ($cached_data) {
                return $cached_data;
            }
        }

        return static::request($method, $url, $params, $args);
    }


    static function getName(): string {
        return static::$name;
    }

    static function setName($name): void {
        self::$name = $name;
    }

    /**
     * @throws \Exception
     */
    static function substitute($route, $substitutions) {
        preg_match_all('/{{(.*?)}}/', $route, $matches);
        $placeholders = $matches[1] ?? [];
        foreach ($placeholders as $placeholder) {
            $value = $substitutions[$placeholder] ?? null;
            if (!$value) {
                throw new \Exception(sprintf(__('Missing substitution value for %s', 'ultimate-crypto-widget'), esc_html($placeholder)));
            }
            $route = str_replace('{{' . $placeholder . '}}', $value, $route);
        }
        return $route;
    }



}