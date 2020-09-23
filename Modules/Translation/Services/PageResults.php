<?php


namespace Modules\Translation\Services;


use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageResults
{
    protected $per_page = 50;

    protected $page = 1;

    protected $filters = [];

    protected $sortCriteria = [];

    protected $sortFields = ['id'];

    protected $sort = ['desc'];

    protected $records = [];

    protected $query;

    protected $search;

    /**
     * @param mixed $per_page
     */
    public function setPerPage($per_page)
    {
        if($per_page) {
            $this->per_page = $per_page;
        }
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        if($page) {
            $this->page = $page;
        }
    }

    /**
     * @return array
     */
    public function getSortCriteria()
    {
        $this->sortCriteria = collect($this->sortFields)->mapWithKeys(function ($item, $k) {
            return [$item => $this->sort[$k]];
        });

        return $this->sortCriteria;
    }

    /**
     * @param mixed $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param mixed $search
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Return paginator as array
     *
     * @return mixed
     */
    public function getResults()
    {
        if($this->search) {
            foreach ($this->filters as $field) {
                $this->query->orWhere($field, 'LIKE', "%{$this->search}%");
            }
        }

        return $this->query->paginate($this->per_page);
    }

    /**
     * @param Request $request
     * @throws \Throwable
     */
    public function validateRequest(Request $request)
    {
        $this->sortFields = explode('|', $request->get('sort_fields', 'id'));
        $this->sort = explode('|', $request->get('sort', 'desc'));

        throw_if(count($this->sort) != count($this->sortFields), ValidationException::withMessages([
            'sort' => ['sort should match fields numbers'],
            'sort_fields' => ['sort fields should match sort ']
        ]));

        $request->validate([
            'page' => 'numeric',
            'per_page' => 'numeric'
        ]);
    }
}
