<?php

namespace EditorSwitch;

defined( 'ABSPATH' ) || exit;   // Exit if accessed directly.

/**
 * Plugin Class.
 *
 * @since 1.0.0
 */
final class Plugin {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize.
	 *
	 * @since 1.1.0
	 */
	public function init() {

		add_action( 'enqueue_block_editor_assets', array( $this, 'load_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'wp_ajax_editor_switch_save_preference', array( $this, 'save_preference' ) );
		add_action( 'init', array( $this, 'switch_editor' ) );
	}

	/**
	 * Load assets on gutenberg area.
	 *
	 * @return void.
	 */
	public function load_assets() {

		wp_enqueue_script(
			'shortcut-dot-js',
			plugins_url( 'assets/js/shortcut.js', EDITOR_SWITCH ),
			array( 'wp-blocks', 'wp-editor' ),
			true
		);
	
		wp_enqueue_script(
			'editor-switch-script',
			plugins_url( 'assets/js/editor-switch.js', EDITOR_SWITCH ),
			array( 'shortcut-dot-js', 'wp-blocks', 'wp-editor' ),
			true
		);

		wp_localize_script(
			'editor-switch-script',
			'editor_switch_plugins_params',
			array(
				'ajax_url'           => admin_url( 'admin-ajax.php' ),
				'switch_nonce'       => wp_create_nonce( 'switch-nonce' ),
			)
		);
	}

	/**
	 * Save user's preferred editor on SHITT + S.
	 *
	 * @since  1.0.0
	 * 
	 * @return void.
	 */
	public function save_preference() {

		// Bail if it is not a admin page.
		if ( ! is_admin() ) {
			return;
		}

		check_admin_referer( 'switch-nonce', 'security' );

		$editor = get_user_meta( get_current_user_id(), 'switch_editor_preference', true );
		$update = 'classic' === $editor ? 'block' : 'classic';	// Update the editor prefrence. If the block is being displayed now, switch to classic and vice-versa.

		update_user_meta( get_current_user_id(), 'switch_editor_preference', $update );
	}

	/**
	 * Switch editor now.
	 *
	 * @since  1.0.0
	 * 
	 * @return void.
	 */
	public function switch_editor() {

		$editor = get_user_meta( get_current_user_id(), 'switch_editor_preference', true );

		if ( 'classic' === $editor ) {
			add_filter( 'use_block_editor_for_post', '__return_false' );
		} else {
			// Let the default be block editor. After all, it is.
			add_filter( 'use_block_editor_for_post', '__return_true' );
		}
	}
}