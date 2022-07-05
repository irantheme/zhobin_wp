<?php

// Adding source files essentials
require get_theme_file_path('/includes/source_files.php');
// Adding custom settings admin page
require get_theme_file_path('/includes/custom_admin_settings.php');
// Adding additional & features
require get_theme_file_path('/includes/additional_features.php');
// Adding register search route
require get_theme_file_path('/includes/search_live_route.php');
// Adding register loading posts route
require get_theme_file_path('/includes/loading_post_route.php');

$settings = new Irantheme_WordPress_Custom_Admin_Settings('تنظیمات قالب', 'irantheme', __FILE__, 'irantheme');
