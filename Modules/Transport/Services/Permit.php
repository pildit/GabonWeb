<?php


namespace Modules\Transport\Services;


use Modules\Transport\Entities\Permit as PermitEntity;

class Permit extends PageResults
{
    public function getPaginator()
    {
        $data = PermitEntity::orderBy($this->getOrderBy(), $this->getOrderDirection())
            ->paginate(50);
        return $data;
    }
}
