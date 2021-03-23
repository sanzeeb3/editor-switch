/* global editor_switch_plugins_params
 *
 * @since 1.0.0
*/
jQuery( function( $ ) {

	shortcut.add( "shift+s", function() {
		var data = {
			action: 'editor_switch_save_preference',
			security: editor_switch_plugins_params.switch_nonce
		};

		$.post( editor_switch_plugins_params.ajax_url, data, function( response ) {
			location.reload();
		});
	});
});