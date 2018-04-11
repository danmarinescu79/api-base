<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-04-03 13:48:32
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 14:00:57
 */

namespace ApiBase\Mapper;

class Pagination
{
    private $pageCount;
    private $itemCountPerPage;
    private $first;
    private $current;
    private $last;
    private $firstPageInRange;
    private $lastPageInRange;
    private $currentItemCount;
    private $totalItemCount;
    private $firstItemNumber;
    private $lastItemNumber;

    /**
     * @return mixed
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @param mixed $pageCount
     *
     * @return self
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemCountPerPage()
    {
        return $this->itemCountPerPage;
    }

    /**
     * @param mixed $itemCountPerPage
     *
     * @return self
     */
    public function setItemCountPerPage($itemCountPerPage)
    {
        $this->itemCountPerPage = $itemCountPerPage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @param mixed $first
     *
     * @return self
     */
    public function setFirst($first)
    {
        $this->first = $first;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param mixed $current
     *
     * @return self
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * @param mixed $last
     *
     * @return self
     */
    public function setLast($last)
    {
        $this->last = $last;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstPageInRange()
    {
        return $this->firstPageInRange;
    }

    /**
     * @param mixed $firstPageInRange
     *
     * @return self
     */
    public function setFirstPageInRange($firstPageInRange)
    {
        $this->firstPageInRange = $firstPageInRange;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastPageInRange()
    {
        return $this->lastPageInRange;
    }

    /**
     * @param mixed $lastPageInRange
     *
     * @return self
     */
    public function setLastPageInRange($lastPageInRange)
    {
        $this->lastPageInRange = $lastPageInRange;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentItemCount()
    {
        return $this->currentItemCount;
    }

    /**
     * @param mixed $currentItemCount
     *
     * @return self
     */
    public function setCurrentItemCount($currentItemCount)
    {
        $this->currentItemCount = $currentItemCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalItemCount()
    {
        return $this->totalItemCount;
    }

    /**
     * @param mixed $totalItemCount
     *
     * @return self
     */
    public function setTotalItemCount($totalItemCount)
    {
        $this->totalItemCount = $totalItemCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstItemNumber()
    {
        return $this->firstItemNumber;
    }

    /**
     * @param mixed $firstItemNumber
     *
     * @return self
     */
    public function setFirstItemNumber($firstItemNumber)
    {
        $this->firstItemNumber = $firstItemNumber;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastItemNumber()
    {
        return $this->lastItemNumber;
    }

    /**
     * @param mixed $lastItemNumber
     *
     * @return self
     */
    public function setLastItemNumber($lastItemNumber)
    {
        $this->lastItemNumber = $lastItemNumber;

        return $this;
    }
}
