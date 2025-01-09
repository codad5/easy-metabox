<?php

namespace CeanWP\Controllers;

class RewriteRules
{
    const RULES = [
        [
            'regex' => '^movies/([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})/?$',
            'template' => 'single-top_grossing_movie.php',
            'after' => 'top',
            'query' => [
                'movie_id' => '$matches[1]'
            ]
        ]
    ];

//    const RULES = [
//        [
//            'regex' => '^movies/([a-f0-9-]+)/?$',
//            'template' => 'single-top_grossing_movie.php',
//            'after' => 'top',
//            'query' => [
//                'movie_id' => '$matches[1]'
//            ]
//        ]
//    ];

    public static function turn_on()
    {
        add_action('init', [self::class, 'add_rewrite_rules']);
        add_filter('query_vars', [self::class, 'add_query_vars']);
        add_filter('template_include', [self::class, 'template_include']);
    }

    static function turn_off()
    {
        remove_action('init', [self::class, 'add_rewrite_rules']);
        remove_filter('query_vars', [self::class, 'add_query_vars']);
        remove_filter('template_include', [self::class, 'template_include']);
    }


    public static function add_rewrite_rules(): void
    {
        foreach (self::RULES as $rule) {
            $query = [];
            foreach ($rule['query'] as $key => $value) {
                // Add dynamic $matches support
                $query[] = $key . '=' . $value;
            }
            $query_string = implode('&', $query);

            add_rewrite_rule($rule['regex'], 'index.php?' . $query_string, $rule['after']);
        }
    }

    public static function add_query_vars($vars): array
    {
        foreach (self::RULES as $rule) {
            foreach ($rule['query'] as $key => $value) {
                $vars[] = $key; // Add custom query var to the list
            }
        }
        return $vars;
    }

    public static function template_include($template): string
    {
        foreach (self::RULES as $rule) {
            $all_vars_valid = true;

            // Check if all query vars for the rule are set and valid
            foreach ($rule['query'] as $key => $value) {
                if (get_query_var($key) === false || get_query_var($key) === '') {
                    $all_vars_valid = false;
                    break; // Skip to the next rule if a query var is invalid
                }
            }

            if ($all_vars_valid) {
                // Return the custom template if all vars are valid
                $custom_template = get_template_directory() . '/' . $rule['template'];
                if (file_exists($custom_template)) {
                    return $custom_template;
                }
            }
        }

        // Return the default template if no rules match
        return $template;
    }
}
