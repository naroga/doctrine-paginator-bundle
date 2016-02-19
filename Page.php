<?php

namespace Naroga\DoctrinePaginatorBundle;

/**
 * Class Page
 * @package Naroga\DoctrinePaginatorBundle
 */
class Page
{
    /** @var integer */
    private $page;
    /** @var integer */
    private $totalItems;
    /** @var integer */
    private $pageItems;
    /** @var integer */
    private $totalPages;
    /** @var array */
    private $items;

    /**
     * Class constructor
     *
     * @param $page         Page number
     * @param $totalItems   Number of items (in all pages)
     * @param $pageItems    Number of items in the current page
     * @param $totalPages   Number of pages
     * @param $items        The items
     */
    private function __construct($page, $totalItems, $pageItems, $totalPages, $items)
    {
        $this->page = $page;
        $this->totalItems = $totalItems;
        $this->pageItems = $pageItems;
        $this->totalPages = $totalPages;
        $this->items = $items;
    }

    /**
     * Static factory to create immutable pages.
     *
     * @param int $page         Page number
     * @param int $totalItems   Number of items (in all pages)
     * @param int $pageItems    Number of items in the current page
     * @param int $totalPages   Number of pages
     * @param array $items      The items
     * @return Page             The filtered resultset.
     */
    public static function create($page, $totalItems, $pageItems, $totalPages, $items)
    {
        return new Page($page, $totalItems, $pageItems, $totalPages, $items);
    }

    /**
     * Get page
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get Total Items
     *
     * @return int
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * @return int
     */
    public function getPageItems()
    {
        return $this->pageItems;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}
