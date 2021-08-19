<?php

namespace search;


class Query
{
    public $searchPhrase;
    public $searchTerms = array();
    /**
     * @var SearchSettings
     */
    public $settings;

    function __construct($settings = null){
    }

    /** Create a new Query Instance.
     *
     * @param string $q The search string
     * @param SearchSettings|null $settings Search options.
     * @return Query The resulting Query instance
     */
    static function newInstance($q, $settings = null){
        $query = new Query();

        if ($settings === null) $settings = new SearchSettings();
        $query->settings = $settings;

        //Original searchphrase
        $query->searchPhrase = $q;

        //Replace characters
        foreach ($query->settings->replaceInSearchString as $word => $replacement) {
            $q = str_replace($word, $replacement, $q);
        }

        //Strip other non-alphanumerics
        $q = preg_replace("/[^A-Za-z0-9 ]/", '', $q);

        //Replace numbers
        $q = NumberConverter::replaceNumbers($q);

        //Lowercase it
        $q = strtolower($q);

        //Break into seperate words array
        $searchArray = explode(" ", $q);

        //Remove words we don't want.
        if ($query->settings->useIgnoredWords) {
            $words = array_merge($query->settings->ignoredWords, $query->settings->freebirdIgnoredWords);
            $searchArray = array_diff($searchArray, $words);
        }

        //Create Terms
        $termArray = array();
        foreach ($searchArray as $term) {
            $term = trim($term);
            if ($term == '') continue;

            //Replace regex
            foreach ($settings->replaceInWords as $pattern => $newValue) {
                $term = preg_replace($pattern, $newValue, $term);
            }

            $termArray[] = Term::newInstance($term);
        }

        $query->searchTerms = $termArray;

        return $query;
    }

    /** Create an array of IndexTerm.
     * This method is used to generate the search terms for products.
     * @param $q
     * @param $category
     * @param $settings SearchSettings
     * @return array
     */
    static function getIndexTerms($q, $category, $settings){
        $query = self::newInstance($q, $settings);
        $indexTerms = array();

        foreach ($query->searchTerms as $term) {
            /**
             * @var $term Term
             */
            if (isset($indexTerms[$term->normalizedTerm])){
                //increase occurrence
                $indexTerms[$term->normalizedTerm]->occurrence++;
            } else {
                //add index term
                $indexTerm = IndexTerm::newInstance($term->normalizedTerm);
                $indexTerm->category = $category;
                $indexTerm->occurrence = 1;
                $indexTerms[$term->normalizedTerm] = $indexTerm;
            }

        }

        //Remove assoc keys
        return array_values($indexTerms);
    }

    /** Get's all the search terms according to the selected method
     *
     * @return array
     */
    public function getMethodTermsArray(){
        $array = array();

        foreach ($this->searchTerms as $searchTerm) {
            /**
             * @var $searchTerm Term
             */

            if ($this->settings->useMetaphone){
                $array[] = $searchTerm->metaphone;
            } else if ($this->settings->useSoundex){
                $array[] = $searchTerm->soundex;
            } else {
                $array[] = $searchTerm->normalizedTerm;
            }

        }

        return $array;
    }

    public function getNormalizedTermsArray(){
        $array = array();

        foreach ($this->searchTerms as $searchTerm) {
            /**
             * @var $searchTerm Term
             */
            $array[] = $searchTerm->normalizedTerm;
        }

        return $array;
    }

}