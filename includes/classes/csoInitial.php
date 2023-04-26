<?php

//require_once 'csoFieldProperties.php';

class csoInitial {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ], 10 );

		add_action( 'init', [ $this, 'run_users_options' ] );
	}

	public function enqueue_admin_scripts( $hook ): void {


		$needed_post_type = isset( $_REQUEST['post_type'] ) && $_REQUEST['post_type'] == CSO_POST_TYPE;

		if ( ( 'post.php' == $hook && get_post_type() == CSO_POST_TYPE ) || ( 'post-new.php' == $hook && $needed_post_type ) ) {
			//Scripts
			wp_enqueue_script( 'html5sortable', CSO_PLUGIN_URL . '/assets/third-party/html5sortable/html5sortable.js' );
			wp_enqueue_script( 'admin-custom-script', CSO_PLUGIN_URL . '/assets/admin/js/admin.js' );

			//Styles
			wp_enqueue_style( 'admin-custom-style', CSO_PLUGIN_URL . '/assets/admin/styles/admin-styles.css' );
		}

	}

	public function run_users_options(): void {
		$options_posts = get_posts( [
			'post_type'      => CSO_POST_TYPE,
			'posts_per_page' => - 1,
		] );

		$fields = new csoFieldProperties();


		foreach ( $options_posts as $options_post ) {
			$settings = new wptSettings( $fields->get_fields_structure_from_post( $options_post->ID ) );
		}
	}

}

new csoInitial();