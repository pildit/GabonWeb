<?php


namespace Modules\Translation\Services;


use Modules\Translation\Entities\Language;

class Translation extends PageResults
{
    /**
     * @return mixed
     */
    public function getPaginator()
    {
        $data = Language::ofSort($this->getSortCriteria())
            ->paginate($this->per_page);
        return $data;
    }

    /**
     * @param array $data
     */
    public function store(array $data)
    {
        $lang = new Language();

        $lang->text_key = $data['text_key'];
        $lang->text_us = $data['text_us'];
        $lang->text_ga = $data['text_ga'];
        $lang->mobile = $data['mobile'] ?? 0;

        $lang->save();

        return $lang;
    }
}
