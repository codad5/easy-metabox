<?php

namespace CeanWP\Libs;

/**
 * Validation Class
 *
 * Handles input validation for various types of fields.
 */
class InputValidator
{
    /**
     * Validate a field value based on its type and options.
     *
     * @param string $type The input type (e.g., text, select, checkbox, etc.).
     * @param mixed $value The value to validate.
     * @param array $field Additional field configuration such as options and attributes.
     * @return bool True if the value is valid, false otherwise.
     */
    public static function validate(string $type, mixed $value, array $field): bool
    {
        switch ($type) {
            case 'text':
            case 'textarea':
                return is_string($value);

            case 'number':
                return is_numeric($value) && (!isset($field['attributes']['min']) || $value >= $field['attributes']['min']) && (!isset($field['attributes']['max']) || $value <= $field['attributes']['max']);

            case 'radio':
            case 'select':
                return in_array($value, array_keys($field['options'] ?? []), true);

            case 'checkbox':
                return is_bool($value) || in_array($value, ["1", "0"], true);

            case 'date':
                return self::validate_date($value);

            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;

            case 'url':
                return filter_var($value, FILTER_VALIDATE_URL) !== false;

            case 'color':
                return preg_match('/^#[a-fA-F0-9]{6}$/', $value) === 1;

            case 'file':
                return self::validate_file($value, $field);

            default:
                // Custom types or unsupported types are assumed valid for now.
                return true;
        }
    }

    /**
     * Validate a date string.
     *
     * @param string $value Date string to validate.
     * @return bool True if valid, false otherwise.
     */
    private static function validate_date(string $value): bool
    {
        return strtotime($value) !== false;
    }

    /**
     * Validate a file input.
     *
     * @param mixed $value The file to validate.
     * @param array $field Additional field configuration such as allowed file types.
     * @return bool True if the file is valid, false otherwise.
     */
    private static function validate_file(mixed $value, array $field): bool
    {
        if (!is_array($value) || !isset($value['tmp_name'], $value['name'])) {
            return false;
        }

        $allowed_types = $field['attributes']['accept'] ?? [];
        $file_type = mime_content_type($value['tmp_name']);

        return empty($allowed_types) || in_array($file_type, $allowed_types, true);
    }
}
