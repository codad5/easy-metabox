<?php

namespace CeanWP\Controllers;

use CeanWP\Types\Models;

class FrontendFormSubmission
{
    private array $forms = [];
    private static FrontendFormSubmission $instance;


    private function __construct()
    {
    }

    static function get_instance(): FrontendFormSubmission
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function add_form(string $form_name, string $method,  array $expected_fields, callable $callback): static
    {
        $form_name = str_starts_with($form_name, 'cean') ? $form_name : "ceanwp_$form_name";
        // expected fields sample data ['name' => ['required' => true, 'type' => 'string'], 'email' => ['required' => true, 'type' => 'email']]
        $this->forms[$form_name] = ['expected_fields' => $expected_fields, 'method' => $method, 'callback' => $callback];
        return $this;
    }

    static function add_post_type_form($form_name, $expected_fields, $callback): static
    {
        return self::get_instance()->add_form($form_name, 'post', $expected_fields, $callback);
    }

    static function add_get_type_form($form_name, $expected_fields, $callback): static
    {
        return self::get_instance()->add_form($form_name, 'get', $expected_fields, $callback);
    }

    static function add_form_from_model(Models $models, string $form_name = null, callable $callback = null): static
    {
        if ($form_name === null) {
            $form_name = $models->get_post_type();
        }
//        echo "<pre>";
//        var_dump($models->get_expected_fields());
        return self::get_instance()->add_form($form_name, 'post', $models->get_expected_fields(), $callback);
    }

    function listen_to_form_submission(): void
    {
        add_action('wp', function () {
            $errors = [];
            try {
                foreach ($this->forms as $form_name => $form) {
                    if (isset($_REQUEST[$form_name]) && $_SERVER['REQUEST_METHOD'] === strtoupper($form['method'])) {
                        $this->process_form($form_name, $form);
                    }
                }
                // if the method type is post it should make a get request to the same page
                // to avoid resubmission of the form
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    wp_redirect($_SERVER['REQUEST_URI']);
                    exit;
                }
            }
            catch (\Exception $e) {
                wp_send_json_error($e->getMessage());
            }
        });
    }

    private function process_form(string $form_name, array $form): void
    {
        $errors = [];
        $data = [];
        foreach ($form['expected_fields'] as $field => $field_data) {
            if (!isset($_REQUEST[$field])) {
                if ($field_data['required']) {
                    $errors[$field] = "$field is required";
                }
            } else {
                $data[$field] = $_REQUEST[$field];
            }
        }
        if (empty($errors)) {
            $form['callback']($data);
        } else {
            wp_send_json_error($errors);
        }
    }

}