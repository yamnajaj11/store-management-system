<?php

if (!function_exists('formatAmount')) {

    function formatAmount($amount)
    {
        $number = rtrim(
            rtrim(
                number_format($amount, 2, '.', ''),
                '0'
            ),
            '.'
        );


        return strtr($number, [
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
        ]);
    }

}