<?php

use Carbon\Carbon;

if (!function_exists('currencyFormat')) {
    function currencyFormat($amount)
    {
        return '$' . number_format($amount, 2);
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return Carbon::parse($date)->format('d M Y');
    }
}

if (!function_exists('capitalizedString')) {
    function capitalizedString($string)
    {
        return ucfirst($string);
    }
}
