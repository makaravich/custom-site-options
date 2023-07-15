<?php

class CSOPT_Initial {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ], 10 );

		add_action( 'init', [ $this, 'run_users_options' ] );
	}

	public function enqueue_admin_scripts( $hook ): void {


		$needed_post_type = isset( $_REQUEST['post_type'] ) && $_REQUEST['post_type'] == CSOPT_POST_TYPE;

		if ( ( 'post.php' == $hook && get_post_type() == CSOPT_POST_TYPE ) || ( 'post-new.php' == $hook && $needed_post_type ) ) {
			//Scripts
			wp_enqueue_script( 'html5sortable', CSOPT_PLUGIN_URL . '/assets/third-party/html5sortable/html5sortable.js' );
			wp_enqueue_script( 'admin-custom-script', CSOPT_PLUGIN_URL . '/assets/admin/js/admin.js' );

			//Styles
			wp_enqueue_style( 'admin-custom-style', CSOPT_PLUGIN_URL . '/assets/admin/styles/admin-styles.css' );
		}

		wp_enqueue_style( 'admin-options', CSOPT_PLUGIN_URL . '/assets/admin/styles/options-page.css' );

	}

	public function run_users_options(): void {
		$options_posts = get_posts( [
			'post_type'      => CSOPT_POST_TYPE,
			'posts_per_page' => - 1,
		] );

		$fields = new CSOPT_Field_Properties();


		foreach ( $options_posts as $options_post ) {
			new CSOPT_Core( $fields->get_fields_structure_from_post( $options_post->ID ) );
		}
	}

}

new CSOPT_Initial();