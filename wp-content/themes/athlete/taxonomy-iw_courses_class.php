<?php

/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 20, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of taxonomy-iw_courses-class
 *
 * @developer duongca
 */
$themes_dir = get_template_directory();
$bt_options = get_option('iw_courses_settings');
$theme = 'athlete';
if ($bt_options['theme']) {
    $theme = $bt_options['theme'];
}
$btport_theme = $themes_dir . '/iw_courses';
$theme_path = '';
if (file_exists($btport_theme) && is_dir($btport_theme)) {
    $theme_path = $btport_theme;
} else {
    $theme_path = WP_PLUGIN_DIR . '/iw_courses/themes/' . $theme;
}
$iwcss_theme = $theme_path . '/taxonomy.php';
if (file_exists($iwcss_theme)) {
    require_once $iwcss_theme;
} else {
    echo __('No theme was found','gmswebdesign');
}