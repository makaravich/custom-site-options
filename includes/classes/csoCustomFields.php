<?php

require_once wp_normalize_path(  'third-party/class.Kama_Post_Meta_Box.php' );
require_once wp_normalize_path(  'csoFieldProperties.php' );

class csoCustomFields extends Kama_Post_Meta_Box_Fields {

	// create custom field `my_field`
	public function opt_post_type( $rg, $var, $post ): string {

		$opt_field_types = [
			'text'      => __( 'Text', 'cg' ),
			'textarea'  => __( 'Text Area', 'cg' ),
			'wp_editor' => __( 'Rich Edit', 'cg' ),
		];

		$field = sprintf( '<select type="%s" id="%s" name="%s" title="%s">',
			$rg->type,
			$rg->id,
			$var->name,
			esc_attr( $rg->title )
		);

		foreach ( $opt_field_types as $id => $field_type ) {
			$field .= '<option value="' . $id . '">' . $field_type . '</option>';
		}

		$field .= '</select>';

		return $var->title . $this->tpl__field( $this->field_desc_concat( $field ) );
	}


	public function fields_container( $rg, $var, $post ): string {
		ob_start();
		$fields = new csoFieldProperties();
		$values = $var->val;

		?>
		<div class="fields-container">
			<ul class="sortable">
				<?php
				$index = 0;

				foreach ( $values as $slug => $value ) {
					$fields->render_field( $var->name, $index, $value );
					$index ++;
				}
				?>
			</ul>

			<div class="add-field-btn" id="add-field-btn" onclick="addNewField('<?php echo $var->name ?>')"
			     data-field-name="<?php echo $var->name ?>">
				<img src="<?php echo CSO_PLUGIN_URL . '/assets/img/square-plus-blue.svg' ?>" alt="+">
			</div>
		</div>

		<?php
		return $var->title . $this->tpl__field( $this->field_desc_concat( ob_get_clean() ) );
	}
}

add_action( 'kama_post_meta_box__fields_class', function () {
	return 'csoCustomFields';
} );


class_exists( 'Kama_Post_Meta_Box' ) && new Kama_Post_Meta_Box(
	[
		'id'        => 'cso',
		'post_type' => 'custom_options',
		'title'     => 'Option fields',
		'fields'    => [
			'menu_title'       => [
				'type'  => 'text',
				'title' => __( 'Menu title', 'cg' ),
			],
			'save_btn_label'   => [
				'type'  => 'text',
				'title' => __( 'Save button label', 'cg' ),
			],
			'fields_container' => [
				'type'  => 'fields_container',
				'title' => 'Custom fields',
			],
		],
	]
);