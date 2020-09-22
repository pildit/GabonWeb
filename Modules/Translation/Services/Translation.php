<?php


namespace Modules\Translation\Services;


use Modules\Translation\Entities\Language;

class Translation extends PageResults
{
    public function getPaginator()
    {
        $data = Language::ofSort($this->getSortCriteria())
            ->paginate($this->per_page);
        return $data;
    }
}
