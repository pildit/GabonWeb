<?php

namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Modules\ForestResources\Entities\DevelopmentUnit as DevelopmentUnitEntity;

class DevelopmentUnit extends PageResults
{

    public function getPaginator()
    {

        $this->query = DevelopmentUnitEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['Name', 'Geometry'])->getResults();
    }


}
