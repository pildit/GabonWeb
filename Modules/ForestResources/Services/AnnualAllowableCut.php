<?php

namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Modules\ForestResources\Entities\AnnualAllowableCut as AnnualAllowableCutEntity;

class AnnualAllowableCut extends PageResults
{

    public function getPaginator()
    {

        $this->query = AnnualAllowableCutEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['Name'])->getResults();
    }


}
