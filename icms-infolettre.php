<?php
/*
Plugin Name: ICMS - Inscription Infolettre
Description: Le plugin génère une modale pour inscription à une infolettre. Cette modale est personalisable par les adminisatrateurs.
Author: Filippa Simard
Version: 1
*/

/**
 * assure que la page est passée par la page d'index
 */
if(!defined('ABSPATH')){
	exit;
}


/**
 * defini les constantes de plugin
 */
function iil_definir_const(){

	if(!defined('IIL_PARAMETRES')){
		global $wpdb;
		define('IIL_PARAMETRES', $wpdb->prefix . 'iil_parametres');
	};

	if(!defined('IIL_INSCRIPTIONS')){
		global $wpdb;
		define('IIL_INSCRIPTIONS', $wpdb->prefix . 'iil_inscriptions');
	}

}
add_action('plugin_loaded', 'iil_definir_const', 0);


/**
 * Crée deux tables de l'activation du plug in, si celles-ci ne sont pas existantes
 */
require_once(plugin_dir_path(__FILE__) . 'includes/iil_activation.php');
register_activation_hook( __FILE__, 'iil_activation' );


/**
 * Supprime la table wp_mon_premier_plugin à la base de données à la désactivation du plugin
 */
function iil_deactivation() {

	global $wpdb;
	$table_parametres = $wpdb->prefix . 'iil_parametres';
	$wpdb->query( "DROP TABLE IF EXISTS $table_parametres" );

	$table_inscriptions = $wpdb->prefix . 'iil_inscriptions';
	$wpdb->query( "DROP TABLE IF EXISTS $table_inscriptions" );

};
register_deactivation_hook( __FILE__, 'iil_deactivation' );


/**
 * ajoute un panneau pour personaliser la modale du côté admin
 */
require_once(plugin_dir_path(__FILE__) . 'includes/iil-panneau-admin.php');


/**
 * charge les styles et scripts
 */
function iil_ajouter_styles_et_scripts() {

	wp_register_style( 'iil-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
	wp_enqueue_style( 'iil-style' );

	wp_register_script( 'iil-script', plugins_url( 'assets/js/main.js', __FILE__ ) );
	wp_enqueue_script( 'iil-script' );

};
add_action( 'init', 'iil_ajouter_styles_et_scripts' );