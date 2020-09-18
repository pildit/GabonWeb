<?php


namespace Modules\Transport\Services;


class Item extends PageResults
{
    public function getPaginator()
    {
        $data = \Modules\Transport\Entities\Item::ofSort($this->getSortCriteria())
            ->paginate($this->per_page);
        return $data;
    }
}
