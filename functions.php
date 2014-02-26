<?php
/**
 * mscfinance theme functions and definitions
 *
 * @package mscfinance
 * @since mscfinance 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since mscfinance 1.0
 */

if ( ! function_exists( 'mscfinance_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since mscfinance 1.0
 */
function mscfinance_setup() {

	require( get_template_directory() . '/inc/options.php' );

	register_nav_menus( array(
		'primary_header' => __( 'Primary Header Menu', 'mscfinance' ),
		'primary_footer' => __( 'Primary Footer Menu', 'mscfinance' ),
		'secondary_footer' => __( 'Secondary Footer Menu', 'mscfinance' ),
		'header_top_nav' => __( 'Header Top Navigation', 'mscfinance' ),
	) );	

	add_editor_style('css/editor-styles.css');
}
endif; // mscfinance_setup

add_shortcode('call', 'call_function');
function call_function() {
	return '<div id="call-now">
		<h1>Call Now:</h1> <p class="number">0800-XXX-XXX</p>
		<p>International Toll-free</p>
		<a href="#" class="button">Click To Call</a>
	</div>';
}


add_action( 'after_setup_theme', 'mscfinance_setup' );

if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name'=> 'Page Sidebar',
		'id' => 'page-sidebar',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="offscreen">',
		'after_title' => '</h2>',
	));	
	register_sidebar(array(
		'name'=> 'Footer First Column',
		'id' => 'footer-first',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="offscreen">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name'=> 'Footer Second Column',
		'id' => 'footer-second',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=> 'Footer Third Column',
		'id' => 'footer-third',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));	
}

add_action('tiny_mce_before_init', 'custom_tinymce_options');
if ( ! function_exists( 'custom_tinymce_options' )) {
	function custom_tinymce_options($init){
		$init['apply_source_formatting'] = true;
		return $init;
	}
}

function get_mscfinance_option($option){
	$options = get_option('mscfinance_theme_options');
	return $options[$option];
}


add_action("gform_field_standard_settings", "custom_gform_standard_settings", 10, 2);
function custom_gform_standard_settings($position, $form_id){
    if($position == 25){
    	?>
        <li style="display: list-item; ">
            <label for="field_placeholder">Placeholder Text</label>
            <input type="text" id="field_placeholder" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
        </li>
        <?php
    }
}
// disable gforms tabindex
add_filter("gform_tabindex", "gform_tabindexer");
function gform_tabindexer() {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}

add_action('gform_enqueue_scripts',"custom_gform_enqueue_scripts", 10, 2);
function custom_gform_enqueue_scripts($form, $is_ajax=false){
    ?>
<script>
    jQuery(function(){
        <?php
        foreach($form['fields'] as $i=>$field){
            if(isset($field['placeholder']) && !empty($field['placeholder'])){
                ?>
                jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').attr('placeholder','<?php echo $field['placeholder']?>');
                <?php
            }
        }
        ?>
    });
    </script>
    <?php
}

if ( ! function_exists( 'get_queried_page' )) {
	function get_queried_page(){
		$curr_url = get_current_url();
		$curr_uri = str_replace(get_bloginfo('url'), '', $curr_url);
		$page = get_page_by_path($curr_uri);
		if($page) return $page;
		return null;
	}
}
if ( ! function_exists( 'get_current_url' )) {
	function get_current_url() {
		$url = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') $url .= 's';
			$url .= '://';

		if ($_SERVER['SERVER_PORT'] != '80') {
			$url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		} else {
			$url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		return $url;
	}
}

add_action('gform_after_submission', 'send_lead_form_data', 10, 2);
function send_lead_form_data($entry, $form){

	$service_url = 'http://services.academicpartnerships.com/APUniversityDataWebAPI/api/Lead/PostLead';
	$curl = curl_init($service_url);

	$curl_post_data = array(
		'FirstName' => $entry['1'],
		'LastName' => $entry['2'],
		'HomePhoneNumber' => ($entry['9'] == 'Home') ? $entry['4'] : '',
		'CellPhoneNumber' => ($entry['9'] == 'Mobile') ? $entry['4'] : '',
		'OtherPhoneNumber' => ($entry['9'] == 'Office') ? $entry['4'] : '',
		'HomeEmail' => $entry['3'],
		'WorkEmail' => '',
		'InstitutionCode' => $entry['12'],
		'ProgramCode' => $entry['13'],
		'IndustryVerticalCode' => $entry['14'],
		'Source' => $entry['10'],
		'SubSource' => $entry['11'],
		'CountryCode' => $entry['8'],
		'PostalCode' => '',
		'ExportToCrm' => true,
		'ExpressedConsent' => true
    );

	// print_r($curl_post_data);    
  
 	$curl_post_data = json_encode($curl_post_data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);	
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	$curl_response = curl_exec($curl);

	// echo '<response>';
	// print_r($curl_response);
	// echo '</response>';
}