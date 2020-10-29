<?php

if(! function_exists('lang')) {
    function lang($key)
    {
        $locale = app()->getLocale();

        $dictionary = app('cache')->remember("local.language", 60, function() use ($locale) {
            return \Modules\Translation\Entities\Language::select([
                'text_key', 'text_us as text_en', 'text_ga as text_fr'
            ])->get()->pluck('text_'.$locale, 'text_key')->toArray();
        });

        return $dictionary[$key] ?? "*{$key}*";
    }
}
