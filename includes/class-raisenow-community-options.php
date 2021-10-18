<?php

require_once 'class-raisenow-community-util.php';

class Raisenow_Community_Options {

	const OPTIONS_ID = RAISENOW_COMMUNITY_PREFIX . '_donation_options';

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
	 * @var array {
	 *              'api_key'   => $options['api_key'],
	 *              'widget_type' => 'lema',
	 *              'widget_language'  => 'en',
	 *              'css'       => '',
	 *              'class'     => 'raisenow_community_donation_form',
	 *              'add_class' => '',
	 *              'one_time_1'  => '10',
	 *              'one_time_2'  => '20',
	 *              'one_time_3'  => '50',
	 *              'one_time_4'  => '100',
	 *              'recurring_1' => '5',
	 *              'recurring_2' => '10',
	 *              'recurring_3' => '30',
	 *              'recurring_4' => '100',
	 *            }
	 */
	private $defaults;

	public function __construct() {
		$this->defaults = Raisenow_Community_Util::get_shortcode_atts();
	}

	/**
	 * Initialize some custom settings
	 */
	public function init() {
		register_setting( RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_options' );

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_shortcode_section',
			__( 'Copy shortcode', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'shortcode_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_basics_section',
			__( 'Donation form basics', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'form_basics_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			__( 'Default Amounts', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'form_amounts_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_code_section',
			__( 'Advanced', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'form_code_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_shortcode',
			__( 'Shortcode', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_shortcode' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_shortcode_section',
			[
				'option_id' => 'shortcode',
				'helptext'  => __( 'To render the donation form, copy and paste this shortcode on any page, post, or a text widget.', RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_api_key',
			__( 'API key', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_text_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_basics_section',
			[
				'option_id' => 'api_key',
				'helptext'  => __( 'API key retrieved by RaiseNow. You should find it in the onboarding email from RaiseNow.', RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_widget_type',
			__( 'Widget type', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_widget_type_option' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_basics_section',
			[
				'option_id' => 'widget_type',
				'helptext'  => __( 'Check the onboarding email from RaiseNow to find out which widget type you should choose.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_widget_language',
			__( 'Widget language', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_widget_language_option' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_basics_section',
			[
				'option_id' => 'widget_language',
				'helptext'  => __( 'Default widget language.', RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_1',
			__( 'One time donation amount 1', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'one_time_1',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_2',
			__( 'One time donation amount 2', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'one_time_2',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_3',
			__( 'One time donation amount 3', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'one_time_3',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_one_time_4',
			__( 'One time donation amount 4', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'one_time_4',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_1',
			__( 'Recurring donation amount 1', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'recurring_1',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_2',
			__( 'Recurring donation amount 2', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'recurring_2',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_3',
			__( 'Recurring donation amount 3', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'recurring_3',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_recurring_4',
			__( 'Recurring donation amount 4', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_number_field' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_amounts_section',
			[
				'option_id' => 'recurring_4',
				'helptext'  => __( 'Default amount. Can be overwritten with the shortcode.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_javascript',
			__( 'Custom script', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_custom_code_option' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_code_section',
			[
				'option_id' => 'javascript',
				'helptext'  => __( 'Enter your javascript above. It will be applied to all donation forms.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		$this->add_code_editor_config( RAISENOW_COMMUNITY_PREFIX . '_donation_options-javascript', 'text/javascript' );

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_css',
			__( 'Custom css', RAISENOW_COMMUNITY_PREFIX ),
			[ $this, 'render_custom_code_option' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_code_section',
			[
				'option_id' => 'css',
				'helptext'  => __( 'Enter your custom css above. It will be applied to all donation forms.',
					RAISENOW_COMMUNITY_PREFIX ),
			]
		);

		$this->add_code_editor_config( RAISENOW_COMMUNITY_PREFIX . '_donation_options-css', 'text/css' );
	}

	public function shortcode_section_header() {
		echo __( 'Copy this shortcode and paste it into your post, page, or text widget:',
			RAISENOW_COMMUNITY_PREFIX );
	}

	public function form_basics_section_header() {
		echo __( 'These settings are mandatory. The form will not work if they are not set up properly.', RAISENOW_COMMUNITY_PREFIX );
	}

	public function form_amounts_section_header() {
		echo __( 'Define the default donation amounts here. They may be overwritten for individual forms using the according shortcode attributes.', RAISENOW_COMMUNITY_PREFIX );
	}

	public function form_code_section_header() {
		echo __( 'Styles and scripts added here are injected on every page that contains a donation form. You probably want to leave this section empty.', RAISENOW_COMMUNITY_PREFIX );
	}

	public function render_shortcode( $args ) {
		$shortcode = '[donation_form ' .
		             'language=&quot;' . $this->defaults['widget_language'] . '&quot; ' .
		             'one_time_1=&quot;' . $this->defaults['one_time_1'] . '&quot; ' .
		             'one_time_2=&quot;' . $this->defaults['one_time_2'] . '&quot; ' .
		             'one_time_3=&quot;' . $this->defaults['one_time_3'] . '&quot; ' .
		             'one_time_4=&quot;' . $this->defaults['one_time_4'] . '&quot; ' .
		             'recurring_1=&quot;' . $this->defaults['recurring_1'] . '&quot; ' .
		             'recurring_2=&quot;' . $this->defaults['recurring_2'] . '&quot; ' .
		             'recurring_3=&quot;' . $this->defaults['recurring_3'] . '&quot; ' .
		             'recurring_4=&quot;' . $this->defaults['recurring_4'] . '&quot;]';

		$options_id = self::OPTIONS_ID;

		echo <<<EOT
<input id="$options_id-{$args['option_id']}" type="text" onfocus="this.select();" readonly="readonly" class="large-text code" value="$shortcode">
<p class="description">
	<label for="$options_id-{$args['option_id']}">{$args['helptext']}</label>
</p>
EOT;
	}

	public function render_text_field( $args ) {
		$name = self::OPTIONS_ID . '[' . $args['option_id'] . ']';
		echo <<<EOT
<input type="text" class="regular-text" name="$name" id="$name" value="{$this->defaults[$args['option_id']]}">
<p class="description">
	<label for="$name" class="description">{$args['helptext']}</label>
</p>
EOT;
	}

	public function render_widget_type_option( $args ) {
		$lema   = checked( 'lema', $this->defaults[ $args['option_id'] ], false );
		$tamaro = checked( 'tamaro', $this->defaults[ $args['option_id'] ], false );

		$name = self::OPTIONS_ID . '[' . $args['option_id'] . ']';

		echo <<<EOT
<fieldset>
	<legend>{$args['helptext']}</legend>
	<input type="radio" value="lema" name="$name" id="$name-lema"$lema>
	<label for="$name-lema">LEMA</label><br>
	<input type="radio" value="tamaro" name="$name" id="$name-tamaro"$tamaro>
	<label for="$name-tamaro">TAMARO</label>
</fieldset>
EOT;
	}

	public function render_widget_language_option( $args ) {
		$de = checked( 'de', $this->defaults[ $args['option_id'] ], false );
		$en = checked( 'en', $this->defaults[ $args['option_id'] ], false );
		$fr = checked( 'fr', $this->defaults[ $args['option_id'] ], false );

		$de_description = __( 'German' );
		$en_description = __( 'English' );
		$fr_description = __( 'French' );

		$name = self::OPTIONS_ID . '[' . $args['option_id'] . ']';

		echo <<<EOT
<fieldset>
	<legend>{$args['helptext']}</legend>
	<input type="radio" value="de" name="$name" id="$name-de"$de>
	<label for="$name-de">$de_description</label><br>
	<input type="radio" value="en" name="$name" id="$name-en"$en>
	<label for="$name-en">$en_description</label><br>
	<input type="radio" value="fr" name="$name" id="$name-fr"$fr>
	<label for="$name-fr">$fr_description</label>
</fieldset>
EOT;
	}

	public function render_number_field( $args ) {
		$name = self::OPTIONS_ID . '[' . $args['option_id'] . ']';
		echo <<<EOT
<input type="number" class="regular-text" name="$name" id="$name" value="{$this->defaults[$args['option_id']]}">
<p class="description">
	<label for="$name">{$args['helptext']}</label>
</p>
EOT;
	}

	public function render_custom_code_option( $args ) {
		$name = self::OPTIONS_ID . '[' . $args['option_id'] . ']';
		$id   = self::OPTIONS_ID . '-' . $args['option_id'];

		echo <<<EOT
<textarea style="resize: both;" name="$name" id="$id">{$this->defaults[$args['option_id']]}</textarea>
<p class="description">
	<label for="$name">{$args['helptext']}</label>
</p>
EOT;
	}

	/**
	 * Add another code editor instance configuration
	 *
	 * @param string $id the id of the textarea that will be replaced with the code editor
	 * @param string $type the MIME type of the code
	 */
	private function add_code_editor_config( $id, $type ) {
		$this->code_editor_config[] = array(
			'id'   => $id,
			'type' => $type,
		);
	}

	public function add_code_editor() {
		foreach ( $this->code_editor_config as $config ) {
			// Enqueue code editor and settings for manipulating script.
			$settings = wp_enqueue_code_editor( array( 'type' => $config['type'] ) );

			// Bail if user disabled CodeMirror.
			if ( false === $settings ) {
				return;
			}

			wp_add_inline_script(
				'code-editor',
				sprintf(
					"jQuery( function() { wp.codeEditor.initialize( '{$config['id']}', %s ); } );",
					wp_json_encode( $settings )
				)
			);
		}
	}
}