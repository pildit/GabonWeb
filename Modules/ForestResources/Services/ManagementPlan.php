<?php

namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Modules\ForestResources\Entities\ManagementPlan as ManagementPlanEntity;

class ManagementPlan extends PageResults
{

    public function getPaginator()
    {

        $this->query = ManagementPlanEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['ManagementUnit', 'Species'])->getResults();
    }


}
