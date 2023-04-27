<?php

class csoFieldProperties {

	/**
	 * Contains structure of the field properties
	 *
	 * @var array
	 */
	protected array $fields_map = [
		[
			'type'    => 'text',
			'id'      => 'title',
			'title'   => 'Title',
			'actions' => [ 'onblur' => 'titleEdited', 'onkeyup' => 'titleKeyUp' ]
		],
		[
			'type'  => 'text',
			'id'    => 'slug',
			'title' => 'Slug',
		],
		[
			'type'    => 'select',
			'id'      => 'type',
			'title'   => 'Field type',
			'options' => [
				'text'      => 'Text',
				'textarea'  => 'Text area',
				'wp_editor' => 'Rich edit',
				'checkbox'  => 'Checkbox',
				'radio'     => 'Radio buttons',
				'select'    => 'Select',
				'email'     => 'Email',
				'password'  => 'Password',
			],
		],
		[
			'type'      => 'textarea',
			'id'        => 'select_options',
			'title'     => 'Options. One per line. Values separated by colon',
			'condition' => [ 'type', '=', 'select' ],
		],
		[
			'type'      => 'textarea',
			'id'        => 'radio_items',
			'title'     => 'Radio buttons. One per line. Values separated by colon',
			'condition' => [ 'type', '=', 'radio' ],
		],
		[
			'type'      => 'checkbox',
			'id'        => 'checkbox_default',
			'title'     => 'Checkbox default state like this:',
			'condition' => [ 'type', '=', 'checkbox' ],
		],
	];

	public function __construct() {

	}

	private function render_actions( $map ): void {
		$actions = $map['actions'] ?? false;
		if ( $actions ) {
			{
				foreach ( $actions as $key => $action ) {
					printf( '%s="%s(this)" ', $key, $action );
				}
			}
		}
	}

	/**
	 * Call different methods of render properties field depends on field type
	 *
	 * @param array $args
	 */
	public function render_single_property( array $args ): void {
		$type_func = 'property_' . strtolower( $args['type'] );

		//echo $type_func;

		if ( is_callable( [ $this, $type_func ] ) ) {
			call_user_func( [ $this, $type_func ], $args );
		}
	}

	public function property_text( $map ): void {
		//print_r( $map);
		?>
		<label>
			<?php echo $map['title'] ?>
			<input class="property-field" type="text"
			       name="<?php echo $map['name'] . '[' . $map['index'] . ']' . '[' . $map['id'] . ']' ?>"
			       value="<?php echo $map['value'] ?>" <?php $this->render_actions( $map ); ?>>
		</label>
		<?php
	}


	/**
	 * Renders field with text area
	 *
	 * @param $map
	 */
	private function property_textarea( $map ): void {
		$attributes = $map['attributes'] ?? '';
		?>
		<label>
			<?php echo $map['title'] ?>
			<textarea class="property-field" <?php echo $attributes ?>
                  name="<?php echo $map['name'] . '[' . $map['index'] . ']' . '[' . $map['id'] . ']' ?>"
                      rows="4"><?php echo $map['value'] ?></textarea>
		</label>
		<?php
	}

	/**
	 * Renders field with select
	 *
	 * @param $map
	 */
	private function property_select( $map ): void {

		$attributes = $map['attributes'] ?? '';
		$options    = $map['options'] ?? [];

		?>
		<label>
			<?php echo $map['title'] ?>
			<select class="property-field" <?php echo $attributes ?>
			        name="<?php echo $map['name'] . '[' . $map['index'] . ']' . '[' . $map['id'] . ']' ?>">
				<?php
				foreach ( $options as $key => $option ) {
					$selected = $key == $map['value'] ? ' selected="selected" ' : '';
					?>
					<option value="<?php echo $key ?>" <?php echo $selected ?>>
						<?php echo $option ?>
					</option>
					<?php
				}
				?>

			</select>
		</label>
		<?php
	}

	/**
	 * Renders field with checkbox
	 *
	 * @param $map
	 */
	private function property_checkbox( $map ): void {
		?>
		<label>
			<?php echo $map['title'] ?>
			<input class="property-field" type="checkbox"
			       name="<?php echo $map['name'] . '[' . $map['index'] . ']' . '[' . $map['id'] . ']' ?>" <?php echo checked( 'on', $map['value'] ) ?> />
		</label>
		<?php
	}

	public function render_field( $name, $index, $values ): void {
		$is_collapsed = $values ? 'collapsed' : '';
		?>
		<li class="single-field <?php echo $is_collapsed ?>"
		    data-common-name="<?php echo $name . '[' . $index . ']' ?>">
			<div class="field-header">
				<div class="title"><?php echo $values['title'] ?? '' ?></div>
				<div class="manage">
					<img src="<?php echo CSO_PLUGIN_URL . '/assets/img/square-delete.svg' ?>" alt="x"
					     onclick="deletePropertyItem(this)">
					<img class="open-field"
					     src="<?php echo CSO_PLUGIN_URL . '/assets/img/circle-arrow-up.svg' ?>" alt="x"
					     onclick="openCloseProperty(this)">
				</div>

			</div>
			<div class="field-body">
				<ul class="single-field-properties">
					<?php foreach ( $this->fields_map as $map ) :
					$condition = isset( $map['condition'] ) ? htmlspecialchars( json_encode( $map['condition'] ) ) : false;
					?>
					<li class="single-property"
						<?php if ( $condition ) {
							echo 'data-condition="' . $condition . '"';
						} ?>>
						<?php
						$map['name']  = $name;
						$map['index'] = $index;
						$map['value'] = $values[ $map['id'] ] ?? '';
						$this->render_single_property( $map );
						?>
					<li>
						<?php endforeach; ?>
				</ul>
			</div>
		</li>
		<?php

	}

	public function get_fields_structure_from_post( $post ): array {
		if ( is_int( $post ) ) {
			$post = get_post( $post );
		}

		$fields_map = [];

		if ( $post ) {

			$fields     = get_post_meta( $post->ID, 'cso_fields_container', true );
			$properties = [];
			foreach ( $fields as $field ) {
				$property = [];
				foreach ( $field as $key => $prop ) {
					if ( $key != 'slug' && ! empty( $prop ) ) {

						if ( $key == 'select_options' ||  $key == 'radio_items'   ) {
							$property['options'] = $this->prepare_options( $prop );
						} else {
							$property[ $key ] = $prop;
						}
					}
				}
				$properties [ $field['slug'] ] = $property;
			}

			$fields_map = [
				'id'          => $post->post_name,
				'page_title'  => get_the_title( $post ),
				'menu_title'  => get_post_meta( $post->ID, 'cso_menu_title', true ),
				'save_button' => get_post_meta( $post->ID, 'cso_save_btn_label', true ),
				'groups'      => [
					'def' => [
						'sections' => [
							'def' => [
								'title'  => '',
								'fields' => $properties,
							],//Can add other sections here
						],
					],//Can add other groups here
				],
			];
		}

		return $fields_map;
	}

	private function prepare_options( $options_str ): array {
		$options_arr = explode( "\n", $options_str );

		$res = [];

		foreach ( $options_arr as $single_option_str ) {
			$single_option = explode( ':', $single_option_str );

			if ( isset ( $single_option[0] ) ) {
				if ( isset ( $single_option[1] ) ) {
					$res[ trim( $single_option[0] ) ] = trim( $single_option[1] );
				} else {
					$res[ trim( $single_option[0] ) ] = trim( $single_option[0] );
				}
			}
		}

		return $res;
	}

}