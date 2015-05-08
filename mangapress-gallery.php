<?php
/**
 * @package Manga_Press
 * @version $Id$
 * @author Jessica Green <jgreen@psy-dreamer.com>
 *
 */
/*
 Plugin Name: Gallery for Manga+Pree
 Plugin URI: http://www.manga-press.com/
 Description: Adds gallery functionality to mangapress
 Version: 0.0.0-alpha
 Author: Jess Green
 Author URI: http://www.jesgreen.com
 Text Domain: mangapress-gallery
 Domain Path: /languages
*/

add_action('plugins_loaded', array('MangaPress_Gallery', 'load_plugin'));

class MangaPress_Gallery
{


    const VERSION = '0.0.0-alpha';

    const DOMAIN  = 'mangapress-gallery';


    /**
     * Plugin folder name
     * @var string
     */
    protected $plugin_folder;


    /**
     * Plugin absolute path
     * @var string
     */
    protected $plugin_path;


    /**
     * Plugin url path
     * @var string
     */
    protected $plugin_url_path;


    /**
     * @var MangaPress_Gallery
     */
    protected static $instance;


    /**
     */
    public static function load_plugin()
    {
        self::$instance = new self();
    }


    /**
     */
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * PHP5 constructor method
     */
    protected function __construct()
    {
        $this->plugin_folder   = basename( __DIR__ );
        $this->plugin_path     = plugin_dir_path( __FILE__ );
        $this->plugin_url_path = plugin_dir_url( __FILE__ );

        load_plugin_textdomain(self::DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages');

        add_action('init', array($this, 'init'), 500);
    }


    /**
     * Initialize plugin
     */
    public function init()
    {
        add_action('do_meta_boxes', array($this, 'remove_mangapress_default_metabox'));
    }


    /**
     * Remove default Manga+Press metabox
     */
    public function remove_mangapress_default_metabox()
    {
        remove_meta_box('comic-image', MangaPress_Posts::POST_TYPE, 'normal');
    }

}