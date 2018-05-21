<?php

class Bro_Excerpt_Length_Options
{

	private $field = 'default_bro_excerpt_length';

	public function __construct()
	{
		add_action('admin_init', array($this, 'add_option_field_to_general_admin_page'));
	}


	function add_option_field_to_general_admin_page()
	{

		register_setting('writing', $this->field, 'intval');

		add_settings_field(
			$this->field,
			__('The number of characters in the excerpt', 'bro_excerpt_length'),
			array($this, 'callback'),
			'writing',
			'default',
			array(
				'id' => $this->field . '-id',
				'option_name' => $this->field
			)
		);
	}

	function callback($val)
	{
		$id = $val['id'];
		$option_name = $val['option_name'];
		?>
        <input
                type="number"
                name="<? echo $option_name ?>"
                id="<? echo $id ?>"
                value="<? echo esc_attr(get_option($option_name, 50)) ?>"
        />
		<?php
	}

}

function bro_excerpt_length_options_init()
{
	new Bro_Excerpt_Length_Options();
}

add_action('plugins_loaded', 'bro_excerpt_length_options_init');