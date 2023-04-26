<?php

require_once 'csoFieldProperties.php';

class csoAJAX {
	public function __construct() {
		//Add AJAX variables
		add_action( 'wp_enqueue_scripts', [ $this, 'ajax_data' ], 20 );
		add_action( 'admin_head', [ $this, 'ajax_admin_data' ] );

		//New field
		add_action( 'wp_ajax_get_default_field', [ $this, 'get_default_field' ] );
		add_action( 'wp_ajax_nopriv_get_default_field', [ $this, 'get_default_field' ] );
	}

	/**
	 * Add AJAX variables to the site code on the frontend
	 */
	function ajax_data(): void {
		$ajax_data = $this->get_ajax_data();
		wp_localize_script( 'admin-custom-script', 'cg_general', $ajax_data );
	}

	/**
	 * Add AJAX variables to the site code on the backend
	 */
	function ajax_admin_data(): void {
		$ajax_data = json_encode( $this->get_ajax_data() );
		?>
		<script type="text/javascript">
            var cg_general = <?php echo $ajax_data; ?>;
		</script>
		<?php
	}


	/**
	 * Contains data to transfer in JS
	 * @return array
	 */
	private function get_ajax_data(): array {
		return [
			'url' => admin_url( 'admin-ajax.php' ),
		];
	}

	/**
	 * Renders an empty field (single property)
	 *
	 * @return void
	 */
	public function get_default_field(): void {
		$index      = isset( $_POST['index'] ) ? htmlspecialchars( $_POST['index'] ) : 0;
		$field_name = isset( $_POST['field_name'] ) ? htmlspecialchars( $_POST['field_name'] ) : '';
		$value      = isset( $_POST['value'] ) ? htmlspecialchars( $_POST['value'] ) : '';

		$fields = new csoFieldProperties();

		$fields->render_field( $field_name, $index, $value );

		wp_die();
	}
}

new csoAJAX();