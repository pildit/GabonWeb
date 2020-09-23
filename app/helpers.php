<?php

if(! function_exists('lang')) {
    function lang($key)
    {
        $locale = app()->getLocale();
        $dictionary = app('cache')->remember("local.language", 60, function() use ($locale) {
            return \Modules\Translation\Entities\Language::all()
                ->pluck('text_'.$locale, 'text_key');
        });

        return $dictionary[$key] ?? "*{$key}*";
    }
}
