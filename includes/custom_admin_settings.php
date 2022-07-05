<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Irantheme_WordPress_Custom_Admin_Settings')) {
	class Irantheme_WordPress_Custom_Admin_Settings
	{
		private $dir;
		private $file;
		// private $assets_dir;
		// private $assets_url;
		private $settings_base;
		private $settings;
		// Text domain string
		private $textdomain;
		// Settings title
		private $settings_title;

		public function __construct($settings_title, $textdomain, $file, $settings_base)
		{
			$this->file = $file;
			$this->dir = dirname($this->file);
			$this->settings_title = $settings_title;
			$this->textdomain = $textdomain;
			// $this->assets_dir = trailingslashit( $this->dir ) . 'assets';
			// $this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
			$this->settings_base = $settings_base . '_';

			// Initialise settings
			add_action('admin_init', array($this, 'init'));

			// Register plugin settings
			add_action('admin_init', array($this, 'register_settings'));

			// Add settings page to menu
			add_action('admin_menu', array($this, 'add_menu_item'));

			// Add settings link to plugins page
			add_filter('plugin_action_links_' . plugin_basename($this->file), array($this, 'add_settings_link'));
		}

		/**
		 * Initialise settings
		 * @return void
		 */
		public function init()
		{
			$this->settings = $this->settings_fields();
		}

		/**
		 * Add settings page to admin menu
		 * @return void
		 */
		public function add_menu_item()
		{
			// Generate retonak settings
			add_menu_page(__($this->settings_title, $this->textdomain), __($this->settings_title, $this->textdomain), 'manage_options', 'plugin_settings', array($this, 'settings_page'), 'dashicons-admin-generic', 110);

			// add_submenu_page('plugin_settings', 'Title', 'Title', 'manage_options', 'plugin_settings', array($this, 'settings_page'));
			// foreach ($this->settings as $section) {
			// 	// add_submenu_page('plugin_settings' . $section['id'], $section['title'], $section['title'], 'manage_options', 'plugin_settings' . $section['id'], array($this, 'settings_page'));
			// }

			// $page = add_options_page( __( $this->settings_title, $this->textdomain ) , __( $this->settings_title, $this->textdomain ) , 'manage_options' , 'plugin_settings' ,  array( $this, 'settings_page' ) );
			// add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
		}

		/**
		 * Add settings link to plugin list table
		 * @param  array $links Existing links
		 * @return array 		Modified links
		 */
		public function add_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=plugin_settings">' . __('Settings', $this->textdomain) . '</a>';
			array_push($links, $settings_link);
			return $links;
		}

		/**
		 * Build settings fields
		 * @return array Fields to be displayed on settings page
		 */
		private function settings_fields()
		{

			// Header configuration fields data
			$settings['header'] = array(
				'title'					=> __('هدر', $this->textdomain),
				'description'			=> __('برخی از تنظیمات هدر قالب', $this->textdomain),
				'fields'				=> array(
					array(
						'id' 			=> 'banner',
						'label'			=> __('شعار سایت', $this->textdomain),
						'description'	=> __('شعار یا معرفی کوتاه سایت.', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> __('متن خود را وارد کنید', $this->textdomain)
					),
					array(
						'id' 			=> 'header_bg',
						'label'			=> __('تصویر پس زمینه هدر', $this->textdomain),
						'description'	=> __('آپلود یا حذف تصویر پس زمینه هدر | پیشنهاد ما استفاده از تصویر افقی می باشد.', $this->textdomain),
						'type'			=> 'image',
						'default'		=> '',
						'placeholder'	=> ''
					),
					array(
						'id' 			=> 'header_extra_description',
						'label'			=> __('توضیحات اضافی هدر', $this->textdomain),
						'description'	=> __('توضیح اضافی هدر که در زیر عنوان اول (توضیحات سایت) قرار میگیرد', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> __('متن خود را وارد کنید', $this->textdomain)
					)
				)
			);

			// Content configuration fields data
			$settings['content'] = array(
				'title' => __('محتوا', $this->textdomain),
				'description' => __('برخی از تنظیمات محتوای قالب', $this->textdomain),
				'fields' => array(
					array(
						'id' => 'content_heading',
						'label' => __('عنوان محتوا'),
						'description' => __('در بالای دسته بندی قرار میگیرد.'),
						'type' => 'text',
						'default' => '',
						'placeholder' => __('متن خود را وارد کنید.', $this->textdomain)
					),
					array(
						'id' => 'content_description',
						'label' => __('توضیحات محتوا', $this->textdomain),
						'description' => __('توضیحات که به صورت نوشته در زیر عنوان محتوا قرار میگیرد.', $this->textdomain),
						'type' => 'textarea',
						'default' => '',
						'placeholder' => __('متن خود را وارد کنید.', $this->textdomain)
					),
				)
			);

			// footer configuration fields data
			$settings['footer'] = array(
				'title' => __('فوتر', $this->textdomain),
				'description' => __('برخی از تنظیمات محتوای فوتر', $this->textdomain),
				'fields' => array(
					array(
						'id' 			=> 'footer_latest_comments_bg',
						'label'			=> __('تصویر پس زمینه نظرات', $this->textdomain),
						'description'	=> __('آپلود یا حذف تصویر پس زمینه نظرات | پیشنهاد ما استفاده از تصویر افقی می باشد.', $this->textdomain),
						'type'			=> 'image',
						'default'		=> '',
						'placeholder'	=> ''
					),
					array(
						'id' => 'footer_copyright_text',
						'label' => __('متن کپی رایت فوتر'),
						'description' => __('متن کپی رایت انتخابی شما جهت نمایش در فوتر.'),
						'type' => 'text',
						'default' => __('کلیه حقوق مادی و معنوی این سایت محفوظ است.', $this->textdomain),
						'placeholder' => __('متن خود را وارد کنید.', $this->textdomain)
					)
				)
			);

			// general
			$settings['social'] = array(
				'title'					=> __('شبکه های اجتماعی', $this->textdomain),
				'description'			=> __('لینک شبکه های اجتماعی که در آن فعالیت دارید.', $this->textdomain),
				'fields'				=> array(
					array(
						'id' 			=> 'social_facebook',
						'label'			=> __('فیس بوک', $this->textdomain),
						'description'	=> __('لینک صفحه مورد نظر خود را وارد کنید.', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> ''
					),
					array(
						'id' 			=> 'social_twitter',
						'label'			=> __('توئیتر', $this->textdomain),
						'description'	=> __('لینک صفحه مورد نظر خود را وارد کنید.', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> ''
					),
					array(
						'id' 			=> 'social_linkedin',
						'label'			=> __('لینکدین', $this->textdomain),
						'description'	=> __('لینک صفحه مورد نظر خود را وارد کنید.', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> ''
					),
					array(
						'id' 			=> 'social_instagram',
						'label'			=> __('اینستاگرام', $this->textdomain),
						'description'	=> __('لینک صفحه مورد نظر خود را وارد کنید.', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> ''
					),
					array(
						'id' 			=> 'social_whatsapp',
						'label'			=> __('واتس آپ', $this->textdomain),
						'description'	=> __('لینک صفحه مورد نظر خود را وارد کنید.', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> ''
					),
					array(
						'id' 			=> 'social_telegram',
						'label'			=> __('تلگرام', $this->textdomain),
						'description'	=> __('لینک صفحه مورد نظر خود را وارد کنید.', $this->textdomain),
						'type'			=> 'text',
						'default'		=> '',
						'placeholder'	=> ''
					)
				)
			);

			$settings = apply_filters('plugin_settings_fields', $settings);

			return $settings;
		}

		/**
		 * Register plugin settings
		 * @return void
		 */
		public function register_settings()
		{
			if (is_array($this->settings)) {
				foreach ($this->settings as $section => $data) {

					// Add section to page
					add_settings_section($section, $data['title'], array($this, 'settings_section'), 'plugin_settings');

					foreach ($data['fields'] as $field) {

						// Validation callback for field
						$validation = '';
						if (isset($field['callback'])) {
							$validation = $field['callback'];
						}

						// Register field
						$option_name = $this->settings_base . $field['id'];
						register_setting('plugin_settings', $option_name, $validation);

						// Add field to page
						add_settings_field($field['id'], $field['label'], array($this, 'display_field'), 'plugin_settings', $section, array('field' => $field));
					}
				}
			}
		}

		public function settings_section($section)
		{
			$html = '<p> ' . $this->settings[$section['id']]['description'] . '</p>' . "\n";
			echo $html;
		}

		/**
		 * Generate HTML for displaying fields
		 * @param  array $args Field data
		 * @return void
		 */
		public function display_field($args)
		{

			$field = $args['field'];

			$html = '';

			$option_name = $this->settings_base . $field['id'];
			$option = get_option($option_name);

			$data = '';
			if (isset($field['default'])) {
				$data = $field['default'];
				if ($option) {
					$data = $option;
				}
			}

			switch ($field['type']) {

				case 'text':
				case 'password':
				case 'number':
					$html .= '<input id="' . esc_attr($field['id']) . '" type="' . $field['type'] . '" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '" value="' . $data . '"/>' . "\n";
					break;

				case 'text_secret':
					$html .= '<input id="' . esc_attr($field['id']) . '" type="text" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '" value=""/>' . "\n";
					break;

				case 'textarea':
					$html .= '<textarea id="' . esc_attr($field['id']) . '" rows="5" cols="50" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '">' . $data . '</textarea><br/>' . "\n";
					break;

				case 'checkbox':
					$checked = '';
					if ($option && 'on' == $option) {
						$checked = 'checked="checked"';
					}
					$html .= '<input id="' . esc_attr($field['id']) . '" type="' . $field['type'] . '" name="' . esc_attr($option_name) . '" ' . $checked . '/>' . "\n";
					break;

				case 'checkbox_multi':
					foreach ($field['options'] as $k => $v) {
						$checked = false;
						if (in_array($k, $data)) {
							$checked = true;
						}
						$html .= '<label for="' . esc_attr($field['id'] . '_' . $k) . '"><input type="checkbox" ' . checked($checked, true, false) . ' name="' . esc_attr($option_name) . '[]" value="' . esc_attr($k) . '" id="' . esc_attr($field['id'] . '_' . $k) . '" /> ' . $v . '</label> ';
					}
					break;

				case 'radio':
					foreach ($field['options'] as $k => $v) {
						$checked = false;
						if ($k == $data) {
							$checked = true;
						}
						$html .= '<label for="' . esc_attr($field['id'] . '_' . $k) . '"><input type="radio" ' . checked($checked, true, false) . ' name="' . esc_attr($option_name) . '" value="' . esc_attr($k) . '" id="' . esc_attr($field['id'] . '_' . $k) . '" /> ' . $v . '</label> ';
					}
					break;

				case 'select':
					$html .= '<select name="' . esc_attr($option_name) . '" id="' . esc_attr($field['id']) . '">';
					foreach ($field['options'] as $k => $v) {
						$selected = false;
						if ($k == $data) {
							$selected = true;
						}
						$html .= '<option ' . selected($selected, true, false) . ' value="' . esc_attr($k) . '">' . $v . '</option>';
					}
					$html .= '</select> ';
					break;

				case 'select_multi':
					$html .= '<select name="' . esc_attr($option_name) . '[]" id="' . esc_attr($field['id']) . '" multiple="multiple">';
					foreach ($field['options'] as $k => $v) {
						$selected = false;
						if (in_array($k, $data)) {
							$selected = true;
						}
						$html .= '<option ' . selected($selected, true, false) . ' value="' . esc_attr($k) . '" />' . $v . '</label> ';
					}
					$html .= '</select> ';
					break;

				case 'image':
					$image_thumb = '';
					if ($data) {
						$image_thumb = wp_get_attachment_thumb_url($data);
					}
					$html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
					$html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . __('Upload an image', $this->textdomain) . '" data-uploader_button_text="' . __('Use image', $this->textdomain) . '" class="image_upload_button button" value="' . __('آپلود تصویر جدید', $this->textdomain) . '" />' . "\n";
					$html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="' . __('حذف تصویر', $this->textdomain) . '" />' . "\n";
					$html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
					break;

				case 'color':
?><div class="color-picker" style="position:relative;">
						<input type="text" name="<?php esc_attr_e($option_name); ?>" class="color" value="<?php esc_attr_e($data); ?>" />
						<div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
					</div>
<?php
					break;
			}

			switch ($field['type']) {

				case 'checkbox_multi':
				case 'radio':
				case 'select_multi':
					$html .= '<br/><span class="description">' . $field['description'] . '</span>';
					break;

				default:
					$html .= '<label for="' . esc_attr($field['id']) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
					break;
			}

			echo $html;
		}

		/**
		 * Validate individual settings field
		 * @param  string $data Inputted value
		 * @return string       Validated value
		 */
		public function validate_field($data)
		{
			if ($data && strlen($data) > 0 && $data != '') {
				$data = urlencode(strtolower(str_replace(' ', '-', $data)));
			}
			return $data;
		}

		/**
		 * Load settings page content
		 * @return void
		 */
		public function settings_page()
		{

			// Build page HTML
			$html = '<div class="wrap" id="plugin_settings">' . "\n";
			$html .= '<h2>' . __($this->settings_title, $this->textdomain) . '</h2>' . "\n";
			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

			// Setup navigation
			$html .= '<ul id="settings-sections" class="subsubsub hide-if-no-js">' . "\n";
			$html .= '<li><a class="tab all current" href="#all">' . __('همه', $this->textdomain) . '</a></li>' . "\n";

			foreach ($this->settings as $section => $data) {
				$html .= '<li><a class="tab" href="#' . $section . '">' . $data['title'] . '</a></li>' . "\n";
			}

			$html .= '</ul>' . "\n";

			$html .= '<div class="clear"></div>' . "\n";

			// Get settings fields
			ob_start();
			settings_fields('plugin_settings');
			do_settings_sections('plugin_settings');
			$html .= ob_get_clean();

			$html .= '<p class="submit">' . "\n";
			$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr(__('ثبت تنظیمات', $this->textdomain)) . '" />' . "\n";
			$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
			$html .= '</div>' . "\n";

			echo $html;
		}
	}
}
