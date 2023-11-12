<?php

declare(strict_types=1);

namespace Santadam\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use Santadam\SortedLinkedList\SortedLinkedList;

class SortedLinkedListTest extends TestCase
{
    public function testInsert(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = new SortedLinkedList();
        $list->insert(1);
        $this->assertTrue($list->contains(1));
    }

    public function testIsEmpty(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = new SortedLinkedList();
        $this->assertTrue($list->isEmpty());
        $list->insert(2);
        $this->assertNotTrue($list->isEmpty());
    }

    public function testContains(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = new SortedLinkedList();

        $this->assertNotTrue($list->contains(3));
        $this->assertNotTrue($list->contains(4));

        $list->insert(3);
        $list->insert(5);
        $list->insert(6);
        $list->insert(6);
        $list->insert(7);

        $this->assertTrue($list->contains(3));
        $this->assertTrue($list->contains(5));
        $this->assertTrue($list->contains(6));
        $this->assertTrue($list->contains(7));
        $this->assertNotTrue($list->contains(4));
    }

    public function testRemove(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = new SortedLinkedList();

        $list->insert(8);
        $this->assertTrue($list->contains(8));

        $list->remove(8);
        $this->assertNotTrue($list->contains(8));
    }

    public function testToArray(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = new SortedLinkedList();

        $this->assertNotTrue($list->contains(3));
        $this->assertNotTrue($list->contains(4));

        $list->insert(6);
        $list->insert(3);
        $list->insert(5);
        $list->insert(6);
        $list->insert(7);
        $this->assertTrue($list->toArray() === [3, 5, 6, 6, 7]);
    }

    public function testFromArray(): void
    {
        /** @var SortedLinkedList<int> $list */
        $list = SortedLinkedList::fromArray([3, 6, 5, 4, 7, 6]);

        $this->assertTrue($list->toArray() === [3, 4, 5, 6, 6, 7]);
    }
}
