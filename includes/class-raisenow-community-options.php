<?php

class Raisenow_Community_Options {

	/**
	 * a code editor will be instantiated for every item in the array.
	 * each item must contain an other array with the keys 'id' and 'type',
	 * whereas the id refers to the textareas id, that should be replaced with
	 * the editor and the type refers to the mime type of the code.
	 *
	 * @var array
	 */
	private $code_editor_config;

	/**
	 * Initialize some custom settings
	 */
	public function init() {
		register_setting(RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_options');

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_shortcode_section',
			__('Copy shortcode', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'shortcode_options_section_header'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_shortcode',
			__('Shortcode', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_shortcode'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_shortcode_section',
		);

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			__('Customize donation form', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'donation_options_section_header'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_api_key',
			__('API key', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_api_key_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'api_key',
				'helptext' => "<p>" . __('Enter your RaiseNow API key.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_widget_type',
			__('Widget type', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_widget_type_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'widget_type',
				'helptext' => "<p>" . __('Select your RaiseNow widget type. Check the onboarding email of RaiseNow to find out which widget type you should choose.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_widget_language',
			__('Widget language', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_widget_language_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'widget_language',
				'helptext' => "<p>" . __('Select your widget language.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_1',
			__('One time donation value 1', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_one_time_1_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'one_time_1',
				'helptext' => "<p>" . __('Enter the first value for one time donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_2',
			__('One time donation value 2', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_one_time_2_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'one_time_2',
				'helptext' => "<p>" . __('Enter the second value for one time donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_3',
			__('One time donation value 3', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_one_time_3_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'one_time_3',
				'helptext' => "<p>" . __('Enter the third value for one time donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_4',
			__('One time donation value 4', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_one_time_4_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'one_time_4',
				'helptext' => "<p>" . __('Enter the fourth value for one time donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_1',
			__('Recurring donation value 1', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_recurring_1_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'recurring_1',
				'helptext' => "<p>" . __('Enter the first value for recurring donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_2',
			__('Recurring donation value 2', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_recurring_2_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'recurring_2',
				'helptext' => "<p>" . __('Enter the second value for recurring donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_3',
			__('Recurring donation value 3', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_recurring_3_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'recurring_3',
				'helptext' => "<p>" . __('Enter the third value for recurring donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_4',
			__('Recurring donation value 4', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_recurring_4_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'recurring_4',
				'helptext' => "<p>" . __('Enter the fourth value for recurring donations.', RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_javascript',
			__('Custom script', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_custom_code_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'javascript',
				'helptext' => "<p>" . __('Enter your javascript below. It will be applied to all donation forms.',
					RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		$this->add_code_editor_config(RAISENOW_COMMUNITY_PREFIX . '_donation_options-javascript', 'text/javascript');

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_css',
			__('Custom css', RAISENOW_COMMUNITY_PREFIX),
			[ & $this, 'render_custom_code_option'],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'css',
				'helptext' => "<p>" . __('Enter your custom css below. It will be applied to all donation forms.',
					RAISENOW_COMMUNITY_PREFIX) . "</p>",
			]
		);

		$this->add_code_editor_config(RAISENOW_COMMUNITY_PREFIX . '_donation_options-css', 'text/css');
	}

	public function donation_options_section_header() {
		echo __('Use the options below to customize your donation form.', RAISENOW_COMMUNITY_PREFIX);
	}

	public function shortcode_options_section_header() {
		echo __('Copy this shortcode and paste it into your post, page, or text widget content:', RAISENOW_COMMUNITY_PREFIX);
	}

	public function render_api_key_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_one_time_1_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_one_time_2_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_one_time_3_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_one_time_4_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_recurring_1_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_recurring_2_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_recurring_3_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_recurring_4_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' class='regular-text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='$input'>";
	}

	public function render_shortcode($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		echo '<div class="inside">
				<p class="description">
					<label>Kopiere diesen Shortcode und füge ihn in den Inhalt einer Seite, eines Beitrags oder eines Text-Widgets ein:</label>
					<span class="shortcode wp-ui-highlight"><input type="text" onfocus="this.select();" readonly="readonly" class="large-text code" value="[donation_form language=&quot;' . $options['widget_language'] . '&quot; one_time_1=&quot;' . $options['one_time_1'] . '&quot; one_time_2=&quot;' . $options['one_time_2'] . '&quot; one_time_3=&quot;' . $options['one_time_3'] . '&quot; one_time_4=&quot;' . $options['one_time_4'] . '&quot; recurring_1=&quot;' . $options['recurring_1'] . '&quot; recurring_2=&quot;' . $options['recurring_2'] . '&quot; recurring_3=&quot;' . $options['recurring_3'] . '&quot; recurring_4=&quot;' . $options['recurring_4'] . '&quot;]"></span>
				</p>
			</div>';
	}

	public function render_widget_type_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$default = $options[$args['option_id']];
		} else {
			$default = 'lema';
		}

		$lema = checked('lema', $default, false);
		$tamaro = checked('tamaro', $default, false);

		echo <<<EOT
<fieldset>
	<legend>{$args['helptext']}</legend>
	<input type="radio" value="lema" name="{$options_id}[{$args['option_id']}]" id="$options_id-{$args['option_id']}-lema"$lema>
	<label for="$options_id-{$args['option_id']}-lema">LEMA</label><br>
	<input type="radio" value="tamaro" name="{$options_id}[{$args['option_id']}]" id="$options_id-{$args['option_id']}-tamaro"$tamaro>
	<label for="$options_id-{$args['option_id']}-tamaro">TAMARO</label>
</fieldset>
EOT;
	}

	public function render_widget_language_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$default = $options[$args['option_id']];
		} else {
			$default = 'de';
		}

		$de = checked('de', $default, false);
		$en = checked('en', $default, false);
		$fr = checked('fr', $default, false);

		$de_description = __('German');
		$en_description = __('English');
		$fr_description = __('French');

		echo <<<EOT
<fieldset>
	<legend>{$args['helptext']}</legend>
	<input type="radio" value="de" name="{$options_id}[{$args['option_id']}]" id="$options_id-{$args['option_id']}-de"$de>
	<label for="$options_id-{$args['option_id']}-de">$de_description</label><br>
	<input type="radio" value="en" name="{$options_id}[{$args['option_id']}]" id="$options_id-{$args['option_id']}-en"$en>
	<label for="$options_id-{$args['option_id']}-en">$en_description</label><br>
	<input type="radio" value="fr" name="{$options_id}[{$args['option_id']}]" id="$options_id-{$args['option_id']}-fr"$fr>
	<label for="$options_id-{$args['option_id']}-fr">$fr_description</label>
</fieldset>
EOT;
	}

	public function render_custom_code_option($args) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options = get_option($options_id);

		if (isset($options[$args['option_id']])) {
			$input = $options[$args['option_id']];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<textarea style='resize: both;' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}'>$input</textarea>";
	}

	/**
	 * Add another code editor instance configuration
	 *
	 * @param string $id the id of the textarea that will be replaced with the code editor
	 * @param string $type the MIME type of the code
	 */
	private function add_code_editor_config($id, $type) {
		$this->code_editor_config[] = array(
			'id' => $id,
			'type' => $type,
		);
	}

	public function add_code_editor() {
		foreach ($this->code_editor_config as $config) {
			// Enqueue code editor and settings for manipulating script.
			$settings = wp_enqueue_code_editor(array('type' => $config['type']));

			// Bail if user disabled CodeMirror.
			if (false === $settings) {
				return;
			}

			wp_add_inline_script(
				'code-editor',
				sprintf(
					"jQuery( function() { wp.codeEditor.initialize( '{$config['id']}', %s ); } );",
					wp_json_encode($settings)
				)
			);
		}
	}
}