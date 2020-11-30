<?php


namespace Modules\Admin\Services;


use App\Services\PageResults;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Role as RoleEntity;

class Role extends PageResults
{
    public function getPaginator(Request $request,string $model,array $searchFields, array $relations = [], array $hidden = [])
    {

        $this->validateRequest($request);
        $this->setPage($request->get('page'));
        $this->setPerPage($request->get('per_page'));
        $this->setSearch($request->get('search'));

        $this->query = $model::ofSort($this->getSortCriteria());
        $this->query->where('name', '!=', 'guest');

        if(count($relations)){
            $this->query =  $this->query->with($relations);
        }
        if($hidden) {
            $model->makeHidden($hidden);
        }

        return $this->setFilters($searchFields)->getResults();
    }
}
