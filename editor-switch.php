<?php
/**
 * Plugin Name: Editor Switch
 * Description: Switch to Classic/Block Editor with SHIFT + S.
 * Version: 1.0.0
 * Author: Sanjeev Aryal
 * Author URI: http://www.sanjeebaryal.com.np
 * Text Domain: editor-switch
 * Domain Path: /languages/
 *
 * @license    GPL-3.0+
 */

defined( 'ABSPATH' ) || exit;	// Exit if accessed directly.

define( 'EDITOR_SWITCH', __FILE__ );

/**
 * Plugin version.
 *
 * @var string
 */
const EDITOR_SWITCH_VERSION = '1.0.0';

require_once __DIR__ . '/src/Plugin.php';

/**
 * Return the main instance of Plugin Class.
 *
 * @since  1.0.0
 *
 * @return Plugin.
 */
function editor_switch_init() {
	$instance = \EditorSwitch\Plugin::get_instance();
	$instance->init();

	return $instance;
}

editor_switch_init();