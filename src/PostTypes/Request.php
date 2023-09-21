<?php declare(strict_types=1);

namespace SR\PostTypes;

class Request
{
    public function __construct()
    {
        add_action('init', function()
        {
            $labels = array(
                'name'                  => _x( 'ShortRest Requests', 'Post type general name', 'wp-shortrest' ),
                'singular_name'         => _x( 'ShortRest Request', 'Post type singular name', 'wp-shortrest' ),
                'menu_name'             => _x( 'ShortRest Requests', 'Admin Menu text', 'wp-shortrest' ),
                'name_admin_bar'        => _x( 'ShortRest Request', 'Add New on Toolbar', 'wp-shortrest' ),
                'add_new'               => __( 'Add New', 'wp-shortrest' ),
                'add_new_item'          => __( 'Add New ShortRest Request', 'wp-shortrest' ),
                'new_item'              => __( 'New ShortRest Request', 'wp-shortrest' ),
                'edit_item'             => __( 'Edit ShortRest Request', 'wp-shortrest' ),
                'view_item'             => __( 'View ShortRest Request', 'wp-shortrest' ),
                'all_items'             => __( 'All ShortRest Requests', 'wp-shortrest' ),
                'search_items'          => __( 'Search ShortRest Requests', 'wp-shortrest' ),
                'parent_item_colon'     => __( 'Parent ShortRest Requests:', 'wp-shortrest' ),
                'not_found'             => __( 'No requests found.', 'wp-shortrest' ),
                'not_found_in_trash'    => __( 'No requests found in Trash.', 'wp-shortrest' ),
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => false,
                'show_in_menu'       => true,
                'has_archive'        => false,
                'hierarchical'       => false,
                'supports'           => array( 'title' ),
            );

            \register_post_type( 'sr_request', $args );
        });
    }
}