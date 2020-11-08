<?php
/**********************************************************************
 * Class Name: Web_Page
 * Written By: KotaroW
 * Date: 19th October, 2020
 * Description: Web_Page class definition
**********************************************************************/

// header guard
if (!defined('ALEXANDER_THE_GREAT')) exit;

include('class-web-page-config.php');
include('class-template.php');

class Web_Page {
    // charset & viewport. change the values if necessary
    private const CHARSET = '<meta charset="utf-8">';
    private const VIEWPORT = '<meta name="viewport" content="width=device-width,initial-scale=1.0">';
    
    // tag formats
    private const TITLE_TAG_FORMAT = '<title>%s</title>';
    private const ICON_TAG_FORMAT = '<link rel="shortcut-icon" href="%s">';
    private const META_TAG_FORMAT = '<meta name="%s" content="%s">';
    private const CSS_TAG_FORMAT = '<link rel="stylesheet" type="text/css" href="%s?v=%s">';
    private const JS_TAG_FORMAT = '<script src="%s?v=%s"></script>';
    
    // properties
    private $url;
    private $config;
    private $template;
    private $page_header = null;
    private $page_contents = null;
    
    /***
     * constructor
     * @param $url: string // $url is used to access webpage config data (json)
     * @param $config: string // configuration file (json)
     * @param $template: string // template location (contents folder)
    ***/
    public function __construct($url, $template) {
        $this->url = $url;
        $this->config = Web_Page_Config::get_config($url);
        $this->template = Template::get_template($template);
    }
    
    /***
     * getter
     * @param $name: string (property name)
     * only $config and $page_contents are asscessible
    ***/
    public function __get($name) {
        if ($name == 'config' || $name == 'page_contents'){
            return $this->$name;
        }
        return null;
    }
    
    /***
     * setter
     * @param $name: string (property name)
     * @param $value: mixed but string preferrable (new property value)
     * only $page_contents is writable. This is for the callback function.
    ***/
    public function __set($name, $value) {
        if ($name == 'page_contents') {
            $this->$name = $value;
        }
    }
    
    /***
     * config value setter
     * @param $key: string (config key)
     * @param $value: mixed (new config value)
    ***/
    public function set_config($key, $value) {
        $this->config[$key] = $value;
    }
    
    /***
     * page header builder
     * @param $num_leading_tabs: int (strict) -> how many tabs do you want to prepend?
    ***/
    public function build_header($num_leading_tabs = 1) {
        $this->page_header ='' . PHP_EOL;
        
        // put the header components together
        $this->page_header .= str_repeat("\t", $num_leading_tabs) . sprintf(self::TITLE_TAG_FORMAT, $this->config[Web_Page_Config::TITLE]) . PHP_EOL;
        
        // charset
        $this->page_header .= str_repeat("\t", $num_leading_tabs) . self::CHARSET . PHP_EOL;
        
        // viewport
        $this->page_header .= str_repeat("\t", $num_leading_tabs) . self::VIEWPORT .PHP_EOL;
        
        // shortcut icon
        $this->page_header .= str_repeat("\t", $num_leading_tabs) . sprintf(self::ICON_TAG_FORMAT, $this->config[Web_Page_Config::ICON]) . PHP_EOL;
        
        // meta
        foreach($this->config[Web_Page_Config::META] as $key => $value) {
            $this->page_header .= str_repeat("\t", $num_leading_tabs) . sprintf(self::META_TAG_FORMAT, $key, $value) . PHP_EOL;
        }
        
        // style
        foreach($this->config[Web_Page_Config::CSS] as $css) {
            $this->page_header .= str_repeat("\t", $num_leading_tabs) . sprintf(self::CSS_TAG_FORMAT, $css, time()) . PHP_EOL;
        }
        
        // script
        foreach($this->config[Web_Page_Config::JS] as $js) {
            $this->page_header .= str_repeat("\t", $num_leading_tabs) . sprintf(self::JS_TAG_FORMAT, $js, time()) . PHP_EOL;
        }
    }
    
    /***
     * contents builder
     * @param $contents_callback: function pointer (strict)
     * callback functions can be defined in the individual pages (whatever/however you want)
    ***/
    public function build_contents($contents_callback) {
        $contents_callback($this->config);
    }
    
    /***
     * page display
     * REMEMBER to call build_header and build_contents before calling this function.
    ***/
    public function display() {
        echo sprintf(
            $this->template,
            $this->page_header,
            $this->page_contents
        );
    }
}
?>