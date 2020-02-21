<?php


namespace Kernel\Container\Services;


interface PagerInterface
{
    /**
     * @param $currentPage
     * @param $numberOfPages
     * @param $sitePage
     * @return string[]
     */
    public function getPages($currentPage, $numberOfPages, $sitePage): array;
}