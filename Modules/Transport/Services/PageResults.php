<?php


namespace Modules\Transport\Services;


class PageResults
{
    protected $per_page;

    protected $page;

    protected $headers;

    protected $filters = [];

    protected $orderBy = 'id';

    protected $orderDirection = 'asc';

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
    public function setPerPage($per_page): void
    {
        $this->per_page = $per_page;
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
    public function setPage($page): void
    {
        $this->page = $page;
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
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return string
     */
    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    /**
     * @param string $orderDirection
     */
    public function setOrderDirection(string $orderDirection): void
    {
        $this->orderDirection = $orderDirection;
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
}
