<?php


namespace Kernel\Container\Services;


interface PagerInterface
{
    /**
     * @param $currentPage
     * @param $numberOfBlocks
     * @param $sitePage
     * @return int[]
     */
    public function getPages($currentPage, $numberOfBlocks, $sitePage): array;

    /**
     * @return int
     */
    public static function getNumberOfBlocks(): int;
}