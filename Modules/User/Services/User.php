<?php

namespace Modules\User\Services;


use App\Services\PageResults;
use Modules\User\Entities\User as UserEntity;

class User extends PageResults
{

    public function getPaginator()
    {

        $this->query = UserEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['firstname', 'lastname', 'email'])->getResults();
    }


}