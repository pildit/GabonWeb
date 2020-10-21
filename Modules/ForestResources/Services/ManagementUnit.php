<?php

namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Modules\ForestResources\Entities\ManagementUnit as ManagementUnitEntity;

class ManagementUnit extends PageResults
{

    public function getPaginator()
    {

        $this->query = ManagementUnitEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['Name', 'Geometry'])->getResults();
    }


}
