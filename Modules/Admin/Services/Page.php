<?php


namespace Modules\Admin\Services;


use App\Services\PageResults;
use App\Services\PaginatorContract;

class Page extends PageResults implements PaginatorContract
{
    public function getPaginator()
    {
        $this->query = \Modules\Admin\Entities\Page::ofSort($this->getSortCriteria());

        return $this->setFilters(['name'])->getResults();
    }
}
