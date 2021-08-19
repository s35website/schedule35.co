<?php
/**
 * Created by PhpStorm.
 * User: Co
 * Date: 23/03/2016
 * Time: 00:23
 */

namespace search;


class Term
{
    public $normalizedTerm, $metaphone, $soundex;

    public function __construct(){

    }


    public static function newInstance($normalizedTerm){
        $term = new Term;
        $term->normalizedTerm = $normalizedTerm;

        $term->soundex = soundex($normalizedTerm);
        $term->metaphone = metaphone($normalizedTerm);

        return $term;

    }



}