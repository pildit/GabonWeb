<?php


namespace Modules\Transport\Services;


use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageResults
{
    protected $per_page = 50;

    protected $page = 1;

    protected $headers;

    protected $filters = [];

    protected $sortCriteria = [];

    protected $sortFields = ['id'];

    protected $sort = ['desc'];

    protected $records = [];

    protected $paginator;

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

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
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
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

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string[] $sortFields
     */
    public function setSortFields(array $sortFields)
    {
        $this->sortFields = $sortFields;
    }

    /**
     * @param string[] $sort
     */
    public function setSort(array $sort)
    {
        $this->sort = $sort;
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
     * @return string[]
     */
    public function getSortFields()
    {
        return $this->sortFields;
    }

    /**
     * @return string[]
     */
    public function getSort()
    {
        return $this->sort;
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
     * @param array $records
     */
    public function setRecords(object $records)
    {
        $this->records = $records;

        return $this;
    }

    /**
     * Return paginator as array
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->paginator->toArray();
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
