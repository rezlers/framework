<?php


namespace Kernel\Container\Services;


interface PagerInterface
{
    /**
     * @param $currentPage
     * @param $numberOfBlocks
     * @param $sitePage
     * @return string[]
     */
    public function getPages($currentPage, $numberOfBlocks, $sitePage): array;

    /**
     * @return array
     */
    public static function getNumberOfBlocks(): int;
}