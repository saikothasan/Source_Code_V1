<?php
namespace App\Services;

use App\Model\Setting;

class TranslateService{

    public static function remove_invalid_charcaters($str)
{
    return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', preg_replace('/\s\s+/', ' ', $str));
}

public static function language_load()
{
    if (\session()->has('language_settings')) {
        $language = \session('language_settings');
    } else {
        $language = Setting::where('key', 'language')->first();
        \session()->put('language_settings', $language);
    }
    return $language;
}

}