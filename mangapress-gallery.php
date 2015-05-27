<?php
/**
 * @package Manga_Press
 * @version $Id$
 * @author Jessica Green <jgreen@psy-dreamer.com>
 *
 */
/*
 Plugin Name: Gallery for Manga+Press
 Plugin URI: http://www.manga-press.com/
 Description: Adds gallery functionality to Manga+Press
 Version: 0.0.0-alpha
 Author: Jess Green
 Author URI: http://www.jesgreen.com
 Text Domain: mangapress-gallery
 Domain Path: /languages
*/
include_once ABSPATH . 'wp-admin/includes/plugin.php';

add_action('plugins_loaded', array('MangaPress_Gallery', 'load_plugin'));

class MangaPress_Gallery
{

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
     * Plugin data
     */
    protected $plugin_data;


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
     * Get instance of
     *
     * @return MangaPress_Gallery
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
        $this->plugin_data = get_plugin_data(__FILE__);

        load_plugin_textdomain(
            self::DOMAIN,
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/languages'
        );

        add_action('init', array($this, 'init'), 500);
    }


    /**
     * Retrieve plugin data
     *
     * @param string $key Optional. Name of plugin data key to retrieve
     * @return array|bool
     */
    public function get_plugin_data($key = '')
    {
        if (empty($key)) {
            return $this->plugin_data;
        }

        if (isset($this->plugin_data[ ucwords($key) ])) {
            return $this->plugin_data[ ucwords($key) ];
        }

        return false;
    }


    /**
     * Initialize plugin
     */
    public function init()
    {
        add_action('do_meta_boxes', array('MangaPress_Gallery', 'remove_mangapress_default_metabox'));
        add_action('do_meta_boxes', array('MangaPress_Gallery', 'add_mangapress_gallery_metabox'));
    }


    /**
     * Remove default Manga+Press metabox and add new metabox
     */
    public static function remove_mangapress_default_metabox()
    {
        remove_meta_box('comic-image', MangaPress_Posts::POST_TYPE, 'normal');
    }


    /**
     * Add Manga+Press Gallery metabox
     */
     public static function add_mangapress_gallery_metabox()
     {
         add_meta_box(
             'comic-gallery',
             __('Gallery', self::DOMAIN),
             array('MangaPress_Gallery', 'gallery_metabox_cb'),
             MangaPress_Posts::POST_TYPE,
            'normal',
            'high'
         );
     }


    /**
     * Gallery metabox callback
     */
     public static function gallery_metabox_cb()
     {
         echo "here";
     }

}