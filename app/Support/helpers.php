<?php

use App\Facades\Auth;
use App\Models\Business;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use libphonenumber\NumberParseException;
use Spatie\Activitylog\Contracts\Activity;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Mime\MimeTypes;

if (! function_exists('parse_url_query_string')) {
    /**
     * Extract the URL query string as an associative array.
     *
     * @param string $url
     *
     * @return array
     */
    function parse_url_query_string(string $url): array
    {
        $output = [];
        $urlData = parse_url($url, PHP_URL_QUERY);

        if ($urlData) {
            parse_str($urlData, $output);
        }

        return $output;
    }
}