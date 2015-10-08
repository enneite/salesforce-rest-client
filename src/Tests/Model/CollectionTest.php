<?php

namespace Enneite\SalesforceRestClient\Tests\Model;

use Enneite\SalesforceRestClient\Model\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    public function testGettersAndSetters()
    {
        $collection = new Collection();

        $collection->setRecords(array(
            'Id' => 1
        ))
            ->setTotalSize(1)
            ->setDone(true);

        $this->assertTrue($collection->isDone());
        $this->assertEquals(1, $collection->getTotalSize());
        $this->assertEquals(array(
            'Id' => 1
        ), $collection->getRecords());
    }

}