<?php
/**
 * Created by PhpStorm.
 * User: Co
 * Date: 06/04/2016
 * Time: 10:32
 */

namespace search;


class NumberConverter
{

    public static function replaceNumbers($searchString){
        $numberRegex = "/( |^)[0-9]{1,2}( |$|. )/";
        $nthRegex = "/( |^)[0-9]{1,2}(st|rd|nd|th)( |$)/";

        $searchString = preg_replace_callback($numberRegex,
            function($matches){
                $match = trim($matches[0]);
                return " " . self::convertNumberToWords($match) . " ";
            },
            $searchString);

        $searchString = preg_replace_callback($nthRegex,
            function($matches){
                $match = trim($matches[0]);
                $match = substr($match, 0, strlen($match) - 2);
                return " " . self::convertNumberToWords($match, true) . " ";
            },
            $searchString);

        return $searchString;
    }

    private static function toNth($word){
        $specials = [
            'one' => 'first',
            'two' => 'second',
            'three' => 'third',
            'five' => 'fifth',
            'eight' => 'eighth',
            'nine' => 'ninth',
            'y' => 'ieth'
        ];

        foreach ($specials as $key => $value) {
            $len = strlen($key);
            if (substr($word, strlen($word) - $len, $len) == $key){
                $word = substr($word, 0, strlen($word) - $len) . $specials[$key];
                return $word;
            }
        }

        //else
        return $word . 'th';
    }

    public static function convertNumberToWords($number, $toNth = false) {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . self::convertNumberToWords(abs($number), $toNth);
        }

        $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . self::convertNumberToWords($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = self::convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= self::convertNumberToWords($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        
        if ($toNth) $string = self::toNth($string);

        return $string;
    }
}