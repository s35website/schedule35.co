<?php
/**
 * Created by PhpStorm.
 * User: Co
 * Date: 27/03/2016
 * Time: 18:08
 */

namespace paging;


/**
 * Class ScrollSettings
 *
 * This class holds all the settings for the Paging Functionality. New settings can easily be added by simply adding
 * new public properties.
 *
 */
class PagingSettings
{
    const SETTINGS_KEY = 'pagingSettings';

    public $perPage;

    public function __construct(){
        //Default settings.
        $this->perPage = 36;

    }

    /** Turns a json encoded settings object into a Settings object.
     * @param $json string The JSON string
     * @return PagingSettings() Will return the settings object. Will return default settings in case json cannot be decoded.
     */
    public static function fromJson($json){
        $settings = new PagingSettings();

        if (!is_string($json)) return $settings;

        $array = json_decode($json, true);

        if ($array === null || !is_array($array)) return $settings;

        //copy properties to Settings object
        $class_vars = get_class_vars(get_class($settings));

        foreach ($class_vars as $name => $value) {
            if (isset($array[$name])){
                $settings->$name = $array[$name];
            }
        }

        return $settings;

    }

    public function isValid(){
        if (!is_numeric($this->perPage)) return false;

        return true;
    }

}