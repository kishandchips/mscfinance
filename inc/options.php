<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'mscfinance_options', 'mscfinance_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'mscfinance' ), __( 'Theme Options', 'mscfinance' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}



/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Theme Options', 'mscfinance' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'mscfinance' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'mscfinance_options' ); ?>
			<?php $options = get_option( 'mscfinance_theme_options' ); ?>

			<table class="form-table">
			
				<tr valign="top"><th scope="row"><?php _e( 'News Page ID', 'mscfinance' ); ?></th>
					<td>
						 <input id="mscfinance_theme_options[news_archive_page_id]" class="regular-text" type="text" name="mscfinance_theme_options[news_archive_page_id]" value="<?php esc_attr_e( $options['news_archive_page_id'] ); ?>" />
					</td>
				</tr>	
			
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'mscfinance' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	$input['news_archive_page_id'] = wp_filter_nohtml_kses( $input['news_archive_page_id'] );
	return $input;
}