<?php
/**
 * Created by PhpStorm.
 * User: Co
 * Date: 27/03/2016
 * Time: 18:08
 */

namespace search;


/**
 * Class SearchSettings
 *
 * This class holds all the settings for the Search Functionality. New settings can easily be added by simply adding
 * new public properties.
 *
 * @package search
 */
class SearchSettings
{
    const SETTINGS_KEY = 'searchSettings';

    public $useMetaphone;
    public $useSoundex;
    public $useIgnoredWords;

    public $ignoreLowerScorePercentage;
    public $demoteLowerScorePercentage;
    public $minScore;

    public $ignoredWords = array();
    public $replaceInSearchString = array();
    public $replaceInWords = array();
    public $freebirdIgnoredWords = array();

    public $minSecondarySheets, $maxSecondarySheets;

    public $weights = array();

    public function __construct(){
        //Default settings.
        $this->useMetaphone = true;
        $this->useSoundex = false;
        $this->useIgnoredWords = true;

        $this->demoteLowerScorePercentage = 80;
        $this->ignoreLowerScorePercentage = 20;

        
        $this->minScore = 40;

        $this->replaceInSearchString = array(
            '$' => 's',
            '@' => 'a',
            '!' => 'l',
            '&' => ' and '
        );

        $this->replaceInWords = array(
            '/ing$/' => 'in',
            '/^bout$/' => 'about'
        );

        $this->ignoredWords = array("a", "the");
        $this->freebirdIgnoredWords = array('freebird',);

        //Default weights
        $this->weights = array(
            'title' => 50,
            'artist' => 50,
            'transcriber' => 50,
            'description' => 10,
        );

        $this->minSecondarySheets = 4;
        $this->maxSecondarySheets = 8;

    }

    /** Turns a json encoded settings object into a Settings object.
     * @param $json string The JSON string
     * @return SearchSettings Will return the settings object. Will return default settings in case json cannot be decoded.
     */
    public static function fromJson($json){
        $settings = new SearchSettings();

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

    public function getMethod(){
        if ($this->useMetaphone) return 'metaphone';
        if ($this->useSoundex) return 'soundex';

        return 'term';

    }

    public function getIgnoredWordsString(){
        return join(', ', $this->ignoredWords);
    }

    public function getFreebirdIgnoredWordsString(){
        return join(', ', $this->freebirdIgnoredWords);
    }

    public function isValid(){
        if (!is_bool($this->useIgnoredWords)) return false;
        if (!is_bool($this->useMetaphone)) return false;
        if (!is_bool($this->useSoundex)) return false;

        if (!is_array($this->ignoredWords)) return false;
        if (!is_array($this->freebirdIgnoredWords)) return false;
        if (!is_array($this->replaceInSearchString)) return false;
        if (!is_array($this->replaceInWords)) return false;

        if (!isset($this->weights)) return false;
        if (!isset($this->weights['title'])) return false;
        if (!isset($this->weights['artist'])) return false;
        if (!isset($this->weights['description'])) return false;
        if (!isset($this->weights['transcriber'])) return false;

        if (!is_int($this->weights['title'])) return false;
        if (!is_int($this->weights['artist'])) return false;
        if (!is_int($this->weights['description'])) return false;
        if (!is_int($this->weights['transcriber'])) return false;

        //These value must be between 0 and 100
        if (!is_int($this->ignoreLowerScorePercentage)) return false;
        if ($this->ignoreLowerScorePercentage < 0) return false;
        if ($this->ignoreLowerScorePercentage > 100) return false;
        if (!is_int($this->demoteLowerScorePercentage)) return false;
        if ($this->demoteLowerScorePercentage < 0) return false;
        if ($this->demoteLowerScorePercentage > 100) return false;

        if (!is_int($this->minSecondarySheets)) return false;
        if (!is_int($this->maxSecondarySheets)) return false;

        if (!is_int($this->minScore)) return false;
        if ($this->minScore < 0) return false;

        return true;
    }

    public function setMethod($method){
        $this->useMetaphone = false;
        $this->useSoundex = false;

        if ($method == 'metaphone'){
            $this->useMetaphone = true;
        } else if($method == 'soundex') {
            $this->useSoundex = true;
        }

        return true;
    }

    public function setWeight($category, $weight){
        $this->weights[$category] = (int) $weight;
    }

    public function setIgnoredWordsFromString($string){
        if (!is_string($string)) return false;

        $array = array_map('trim', explode(',', $string));

        if (!is_array($array)) return false;
        if (count($array) == 0) return false;

        $this->ignoredWords = $array;

        return true;
    }

    public function setFreebirdIgnoredWordsFromString($string){
        if (!is_string($string)) return false;

        $array = array_map('trim', explode(',', $string));

        if (!is_array($array)) return false;
        if (count($array) == 0) return false;

        $this->freebirdIgnoredWords = $array;

        return true;
    }


}