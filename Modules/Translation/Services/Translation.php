<?php


namespace Modules\Translation\Services;


use App\Services\PageResults;
use Modules\Translation\Entities\Language;

class Translation extends PageResults
{
    /**
     * @return mixed
     */
    public function getPaginator()
    {
        $this->query = Language::ofSort($this->getSortCriteria());

        return $this->setFilters(['text_key', 'text_us', 'text_ga'])->getResults();

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

    public function update(Language $lang, array $data)
    {
        $lang->text_key = $data['text_key'] ??
    }
}
