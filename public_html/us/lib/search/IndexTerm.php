<?php
/**
 * Created by PhpStorm.
 * User: Co
 * Date: 24/03/2016
 * Time: 09:49
 */

namespace search;


class IndexTerm extends Term
{
    public $category, $occurrence;

    public static function newInstance($normalizedTerm)
    {
        $term = parent::newInstance($normalizedTerm);

        $indexTerm = new IndexTerm();
        $indexTerm->metaphone = $term->metaphone;
        $indexTerm->soundex = $term->soundex;
        $indexTerm->normalizedTerm = $normalizedTerm;

        return $indexTerm;

    }

}