<?php

declare(strict_types=1);

namespace Santadam\SortedLinkedList;

use Closure;

/**
 * @template TElem Data type of the linked list node
 */
class SortedLinkedList
{
    /** @var SortedLinkedListNode<TElem>|null $start */
    private ?SortedLinkedListNode $start = null;

    /**
     * @var callable(TElem, TElem): boolean $elemCmp
     */
    private mixed $elemCmp;

    /**
     * @param null|callable(TElem, TElem): boolean $elemCmp
     */
    public function __construct(
        ?callable $elemCmp = null,
    ) {
        /**
         * @var Closure(TElem, TElem): boolean $defaultElemCmp
         */
        $defaultElemCmp = fn ($a, $b) => $a < $b;
        $this->elemCmp = $elemCmp ?? $defaultElemCmp;
    }


    /** @param TElem $elem */
    public function insert(mixed $elem): void
    {
        // Find the position of the required element and insert after the elem
        $foundNode = $this->findPredecessor($elem);

        // If list empty, trivial
        if ($foundNode === null) {
            $newNode = new SortedLinkedListNode(
                next: $this->start,
                data: $elem,
            );
            $this->start = $newNode;
            return;
        }

        // Perform insertion after the predecessor
        $newNode = new SortedLinkedListNode(
            $foundNode->getNext(),
            $elem,
        );
        $foundNode->setNext($newNode);
    }

    /** @param TElem $elem */
    public function remove(mixed $elem): void
    {
        $nodeToRemove = $this->find($elem);

        if ($nodeToRemove === null) {
            // Nothing to remove
            return;
        }

        if ($this->start === $nodeToRemove) {
            // Starting node is being removed
            $this->start = $nodeToRemove->getNext();
        } else {
            // Non-starting node is being removed
            $predecessor = $this->start;
            assert($predecessor instanceof SortedLinkedListNode);
            while ($predecessor->getNext() !== $nodeToRemove && $predecessor->getNext() !== null) {
                $predecessor = $predecessor->getNext();
            }
            assert($predecessor instanceof SortedLinkedListNode);
            $predecessor->setNext($nodeToRemove->getNext());
        }

        // Perform deletion
        unset($nodeToRemove);
    }

    /**
     * @param TElem $elem
     * @return bool True if linked list contains the specified data, false otherwise.
     */
    public function contains(mixed $elem): bool
    {
        return $this->find($elem) !== null;
    }

    public function isEmpty(): bool
    {
        return $this->start === null;
    }

    /**
     * @param TElem $elem
     * @return SortedLinkedListNode<TElem>|null Returns node if linked list contains the specified data, null otherwise.
     */
    protected function find(mixed $elem): ?SortedLinkedListNode
    {
        /** @var SortedLinkedListNode<TElem>|null $currNode */
        $currNode = $this->start;
        while ($currNode !== null) {
            // Test for equality
            if (!($this->elemCmp)($currNode->getData(), $elem) && !($this->elemCmp)($elem, $currNode->getData())) {
                return $currNode;
            }
            $currNode = $currNode->getNext();
        }
        // Data not found
        return null;
    }

    /**
     * Finds a node to become a predecessor if elem is about to be inserted. Returns null if the value should be
     * inserted at the beginning.
     *
     * @param TElem $elem
     * @return SortedLinkedListNode<TElem>|null Node to become a predecessor. Null if the value should be inserted at
     * the beginning.
     */
    protected function findPredecessor(mixed $elem): ?SortedLinkedListNode
    {
        if ($this->isEmpty()) {
            return null;
        }
        /** @var SortedLinkedListNode<TElem>|null $currNode */
        $currNode = $this->start;
        /** @var SortedLinkedListNode<TElem>|null $prevNode */
        $prevNode = null;
        while ($currNode !== null && ($this->elemCmp)($currNode->getData(), $elem)) {
            $prevNode = $currNode;
            $currNode = $currNode->getNext();
        }
        return $prevNode;
    }

    /**
     * @return TElem[]
     */
    public function toArray(): array
    {
        $res = [];
        /** @var SortedLinkedListNode<TElem> $currNode */
        $currNode = $this->start;
        while ($currNode->getNext() !== null) {
            $res[] = $currNode->getData();
            $currNode = $currNode->getNext();
        }
        $res[] = $currNode->getData();
        return $res;
    }

    /**
     * @param TElem[] $array
     * @param null|callable(TElem, TElem): boolean $elemCmp
     * @return SortedLinkedList<TElem>
     */
    public static function fromArray(array $array, ?callable $elemCmp = null): SortedLinkedList
    {
        /** @var SortedLinkedList<TElem> $list */
        $list = new SortedLinkedList($elemCmp);
        foreach ($array as $item) {
            $list->insert($item);
        }
        return $list;
    }
}
