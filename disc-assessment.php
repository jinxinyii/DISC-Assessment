<?php
/*
Plugin Name: DISC Assessment
Description: A DISC personality assessment tool with email and chart features.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) exit;

// Shortcode to display the assessment form
function disc_assessment_shortcode() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'assessment.php';
    return ob_get_clean();
}
add_shortcode('disc_assessment', 'disc_assessment_shortcode');