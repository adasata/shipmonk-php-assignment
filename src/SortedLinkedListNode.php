<?php

declare(strict_types=1);

namespace Santadam\SortedLinkedList;

/**
 * @template TElem Data type of the linked list node
 */
class SortedLinkedListNode
{
    public function __construct(
        /** @var SortedLinkedListNode<TElem>|null $next */
        private ?SortedLinkedListNode $next,
        /** @var TElem $data */
        private mixed $data,
    ) {
    }

    /**
     * @return SortedLinkedListNode<TElem>|null
     */
    public function getNext(): ?SortedLinkedListNode
    {
        return $this->next;
    }

    /**
     * @param SortedLinkedListNode<TElem>|null $next
     */
    public function setNext(?SortedLinkedListNode $next): void
    {
        $this->next = $next;
    }

    /**
     * @return TElem
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param TElem $data
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}
