<?php

include_once __DIR__ . '/includes/cean-class-autoloader.php';

use CeanWP\Core\CeanWP;
use CeanWP\Models\Cean_WP_Top_Grossing_Movies;
use CeanWP\Models\CeanWP_Contact_Form;

class CeanWP_Functions extends CeanWP
{
    function launch(): void
    {
        add_shortcode('codad5_contact_form_advanced', [$this, 'codad5_advanced_contact_form']);
        parent::start();
    }

    static function get_all_time_top_grossing_movies(): array
    {
        // getting all time grossing movies
        return Cean_WP_Top_Grossing_Movies::get_top_grossing_movies();
    }

    static function get_inquiry_type() : array
    {
        return CeanWP_Contact_Form::INQUIRY_TYPES;
    }

    static function get_heard_about_us() : array
    {
        return CeanWP_Contact_Form::HEARD_ABOUT_US;
    }

// Shortcode for Contact Us Form
    function codad5_advanced_contact_form() {
        ob_start();
        ?>
        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
            <div>
                <label for="cf_first_name">First Name <span>*</span></label>
                <input type="text" id="cf_first_name" name="cf_first_name" required>
            </div>
            <div>
                <label for="cf_last_name">Last Name <span>*</span></label>
                <input type="text" id="cf_last_name" name="cf_last_name" required>
            </div>
            <div>
                <label for="cf_email">Email <span>*</span></label>
                <input type="email" id="cf_email" name="cf_email" required>
            </div>
            <div>
                <label for="cf_phone">Phone Number</label>
                <input type="tel" id="cf_phone" name="cf_phone">
            </div>
            <div>
                <label for="cf_inquiry_type">Inquiry Type</label>
                <select id="cf_inquiry_type" name="cf_inquiry_type">
                    <option value="">Select Inquiry Type</option>
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Support">Support</option>
                    <option value="Feedback">Feedback</option>
                </select>
            </div>
            <div>
                <label for="cf_heard_about_us">How Did You Hear About Us?</label>
                <select id="cf_heard_about_us" name="cf_heard_about_us">
                    <option value="">Select</option>
                    <option value="Google">Google</option>
                    <option value="Social Media">Social Media</option>
                    <option value="Friend">Friend</option>
                </select>
            </div>
            <div>
                <label for="cf_message">Message</label>
                <textarea id="cf_message" name="cf_message" rows="6" required></textarea>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="cf_terms" required>
                    I agree with <a href="/terms-of-use">Terms of Use</a> and <a href="/privacy-policy">Privacy Policy</a>
                </label>
            </div>
            <div>
                <input type="submit" name="cf_submit" value="Send Your Message">
            </div>
        </form>
        <?php
        return ob_get_clean();
    }

// Handle Form Submission
    function codad5_handle_advanced_form_submission() {
        if (isset($_POST['cf_submit'])) {
            $first_name = sanitize_text_field($_POST['cf_first_name']);
            $last_name = sanitize_text_field($_POST['cf_last_name']);
            $email = sanitize_email($_POST['cf_email']);
            $phone = sanitize_text_field($_POST['cf_phone']);
            $inquiry_type = sanitize_text_field($_POST['cf_inquiry_type']);
            $heard_about_us = sanitize_text_field($_POST['cf_heard_about_us']);
            $message = sanitize_textarea_field($_POST['cf_message']);
            $terms = isset($_POST['cf_terms']) ? 'Agreed' : 'Not Agreed';

            // Create a new post in the custom post type
            $post_id = wp_insert_post(array(
                'post_type' => 'contact_form_sub',
                'post_title' => "$first_name $last_name",
                'post_content' => $message,
                'post_status' => 'publish',
                'meta_input' => array(
                    'First Name' => $first_name,
                    'Last Name' => $last_name,
                    'Email' => $email,
                    'Phone' => $phone,
                    'Inquiry Type' => $inquiry_type,
                    'How Did You Hear About Us' => $heard_about_us,
                    'Terms Agreement' => $terms,
                ),
            ));

            if ($post_id) {
                echo '<div class="success-message">Thank you for reaching out! Your message has been submitted.</div>';
            } else {
                // check if it wp_error
                if (is_wp_error($post_id)) {
                    echo '<pre>';
                    print_r($post_id);
                    echo '</pre>';
                }
                echo '<div class="error-message">There was an issue submitting your message. Please try again.</div>';
            }
        }
    }


}

$ceanwp = new CeanWP_Functions();
$ceanwp->launch();