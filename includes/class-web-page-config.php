<?php
/**********************************************************************
 * Class Name: Web_Page_Config
 * Written By: KotaroW
 * Date: 19th October, 2020
 * Description:
 *      Web_Page_Config class definition.
**********************************************************************/
    //if (!defined('ALEXANDER_THE_GREAT')) exit;

    define('PLEASE_GIMME_THE_CONFIG', 'please give me the configurations');

    abstract class Web_Page_Config {
        private const CONFIG_FILE = 'json-web-page-config.php';
        
        const TITLE = 'title';
        const ICON  = 'icon';
        const META  = 'meta';
        const CSS   = 'css';
        const JS    = 'js';
        const CONTENT   = 'content';
        const FOOTER    = 'footer';
            
        private static $instance = null;
        private static $config = array(
            self::TITLE => null,
            self::ICON  => null,
            self::META  => [],
            self::CSS   => [],
            self::JS    => [],
            self::CONTENT   => null, // url
            self::FOTTER    => null // url
        
        );
        
        /***
         * webpage configuration getter
         * @param $url: string // without file extension
        ***/
        public static function get_config($url) {
            include_once (self::CONFIG_FILE);

            //$_config_data resides in the config file
            $config_data = json_decode($_config_data, true);
       
            // if data loading fails return a null value
            if (json_last_error()) {
                return null;
            }
            
            foreach($config_data as $key => $value) {
                switch($key) {
                    case self::ICON:
                    case self::FOOTER:
                        $config[$key] = $value;
                        break;
                    default:
                        $config[$key] = $value[$url];
                        break;
                }
            }
            return $config;
        }
    }
?>