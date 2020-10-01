<?php


namespace Modules\Admin\Services;


use App\Services\PageResults;
use Modules\Admin\Entities\Permission as PermissionEntity;

class Permission extends PageResults
{
    public function getPaginator()
    {
        $this->query = PermissionEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['name'])->getResults();
    }
}
