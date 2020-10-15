<?php


namespace Modules\Admin\Services;


use App\Services\PageResults;
use Modules\Admin\Entities\Role as RoleEntity;

class Role extends PageResults
{
    public function getPaginator()
    {
        $this->query = RoleEntity::with('permissions')->ofSort($this->getSortCriteria());

        return $this->setFilters(['name'])->getResults();
    }
}
