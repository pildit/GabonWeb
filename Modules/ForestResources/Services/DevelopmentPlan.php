<?php

namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Modules\ForestResources\Entities\DevelopmentPlan as DevelopmentPlanEntity;

class DevelopmentPlan extends PageResults
{

    public function getPaginator()
    {

        $this->query = DevelopmentPlanEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['DevelopmentUnit', 'VolumeTariff'])->getResults();
    }


}
