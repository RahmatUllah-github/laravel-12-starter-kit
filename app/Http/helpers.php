<?php

use Illuminate\Database\Schema\Builder;

function maxString()
{
    return 'max:'.Builder::$defaultStringLength;
}

function maxInteger()
{
    return 'max:';
}

function maxBigInteger()
{
    return 'max:';
}

function notNull($value): bool
{
    if (is_null($value) || $value === false) {
        return false;
    }

    if (is_string($value)) {
        $trimmedValue = trim($value);
        return $trimmedValue !== '' && strtolower($trimmedValue) !== 'null';
    }

    if (is_array($value) || is_object($value)) {
        return !empty((array) $value);
    }

    return true;
}

function maxImageSize()
{
    $maxSizeKB = 5 * 1024; // Get max size in KB
    $maxSizeMB = round($maxSizeKB / 1024); // Convert KB to MB

    return [
        'rule' => 'max:' . $maxSizeKB,
        'message' => "The image size exceeds the maximum allowed size of {$maxSizeMB} MB."
    ];
}

function addLeadingSlash($path)
{
    if (substr($path, 0, 1) !== '/') { // check if the first character is not a slash
        $path = '/' . $path;
    }

    return $path;
}

function removeLeadingSlash($path)
{
    if (substr($path, 0, 1) === '/') { // Check if the first character is a slash
        $path = ltrim($path, '/'); // Remove the leading slash
    }

    return $path;
}

function addTrailingSlash($path)
{
    if (substr($path, -1) !== '/') { // check if no trailing slash then add slash
        $path .= '/';
    }

    return $path;
}

function removeTrailingSlash($path)
{
    if (substr($path, -1) === '/') { // Check if the last character is a slash
        $path = rtrim($path, '/'); // Remove the trailing slash
    }

    return $path;
}

function removeWhiteSpaces($string)
{
    return str_replace(' ', '_', $string);
}

/**
 * Convert a number to its ordinal representation (1st, 2nd, 3rd, 4th etc.).
 */
function ordinal($number)
{
    $suffixes = ['th', 'st', 'nd', 'rd'];
    $mod100 = $number % 100;
    $suffix = ($mod100 >= 11 && $mod100 <= 13) ? 'th' : ($suffixes[$number % 10] ?? 'th');
    return $number . $suffix;
}