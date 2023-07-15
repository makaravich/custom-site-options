<?php

class CSOPT_Custom_Options {
	public function __construct() {
		add_action( 'init', [ $this, 'register_cpt' ] );
	}

	/**
	 * Registers custom post type um_portfolio
	 *
	 * @return void
	 */
	public function register_cpt(): void {
		register_post_type( CSOPT_POST_TYPE, [
			'taxonomies'    => [],
			// post related taxonomies
			'label'         => null,
			'labels'        => [
				'name'              => 'Custom site options', // name for the post type.
				'singular_name'     => 'Options record', // name for single post of that type.
				'add_new'           => 'Add Options record', // to add a new post.
				'add_new_item'      => 'Adding Options record', // title for a newly created post in the admin panel.
				'edit_item'         => 'Edit Options record', // for editing post type.
				'new_item'          => 'New Options record', // new post's text.
				'view_item'         => 'See Options record', // for viewing this post type.
				'search_items'      => 'Search Options record', // search for these post types.
				'not_found'         => 'Not Found', // if search has not found anything.
				'parent_item_colon' => '', // for parents (for hierarchical post types).
				'menu_name'         => 'Custom site options', // menu name.
			],
			'description'   => '',
			'public'        => true,
			//'publicly_queryable'  => null, // depends on public
			//'exclude_from_search' => null, // depends on public
			//'show_ui'             => null, // depends on public
			//'show_in_nav_menus'   => null, // depends on public
			'show_in_menu'  => null,
			// whether to in admin panel menu
			//'show_in_admin_bar'   => null, // depends on show_in_menu.
			'show_in_rest'  => false,
			// Add to REST API. WP 4.7.
			'rest_base'     => null,
			// $post_type. WP 4.7.
			'menu_position' => null,
			'menu_icon'     => 'dashicons-admin-generic',
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // Array of additional rights for this post type.
			//'map_meta_cap'      => null, // Set to true to enable the default handler for meta caps.
			'hierarchical'  => false,
			// [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats' ]
			'supports'      => [ 'title' ],
			'has_archive'   => false,
			'rewrite'       => true,
			'query_var'     => true,
		] );

	}


}

new CSOPT_Custom_Options();