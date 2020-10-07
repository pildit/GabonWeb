<?php

namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Modules\ForestResources\Entities\Parcel as ParcelEntity;

class Parcel extends PageResults
{

    public function getPaginator()
    {

        $this->query = ParcelEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['Name', 'Geometry'])->getResults();
    }


}
