<?php

namespace Enneite\SalesforceRestClient\Model;


class Collection
{
    /**
     * records
     *
     * @var array
     */
    protected $records = array();

    /**
     * api called : true else : false
     * @var bool
     */
    protected $done = false;

    /**
     * totalsize of records (for pagination)
     *
     * @var int
     */
    protected $totalSize = 0;

    /**
     * records getter
     *
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * records setter
     *
     * @param array $records
     * @return $this
     */
    public function setRecords($records)
    {
        $this->records = $records;

        return $this;
    }

    /**
     * done getter
     *
     * @return boolean
     */
    public function isDone()
    {
        return $this->done;
    }

    /**
     * done setter
     *
     * @param boolean $done
     * @return $this
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * total size getter
     *
     * @return int
     */
    public function getTotalSize()
    {
        return $this->totalSize;
    }

    /**
     * total size setter
     *
     * @param int $totalSize
     * @return $this
     */
    public function setTotalSize($totalSize)
    {
        $this->totalSize = $totalSize;

        return $this;
    }


}