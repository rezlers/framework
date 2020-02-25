<?php


namespace Kernel\Container\Services\Implementations;


use Kernel\Container\Services\PagerInterface;

class MyPager implements PagerInterface
{

    protected static $configuration;

    /**
     * @var int
     */
    private $pagerSize;

    public function __construct($configuration)
    {
        $this->configurePager($configuration);
    }

    ## 0 ~ ...

    /**
     * @param $currentPage
     * @param $pagerSize
     * @param $numberOfPages
     * @return array
     */
    private function getNeighbor($currentPage, $pagerSize, $numberOfPages) {
        if (($pagerSize - 1) % 2 == 0) {
            $halfPagerSize = ($pagerSize - 1) / 2;
            if (1 + $halfPagerSize >= $currentPage) {
                $resultingArray = range(1, 2*$halfPagerSize + 1);
                $resultingArray[] = 0;
                return $resultingArray;
            } elseif ($numberOfPages - $halfPagerSize <= $currentPage) {
                $resultingArray = range($numberOfPages - 2*$halfPagerSize, $numberOfPages);
                array_unshift($resultingArray, 0);
                return $resultingArray;
            } else {
                $resultingArray = range($currentPage - $halfPagerSize, $currentPage + $halfPagerSize);
                array_unshift($resultingArray, 0);
                $resultingArray[] = 0;
                return $resultingArray;
            }
        } else {
            $halfPagerSize = intdiv($pagerSize - 1, 2);
            if (1 + $halfPagerSize >= $currentPage) {
                $resultingArray = range(1, $pagerSize);
                $resultingArray[] = 0;
                return $resultingArray;
            } elseif ($numberOfPages - $halfPagerSize <= $currentPage) {
                $resultingArray = range($numberOfPages - $pagerSize + 1, $numberOfPages);
                array_unshift($resultingArray, 0);
                return $resultingArray;
            } else {
                $resultingArray = range($currentPage - $halfPagerSize, $currentPage + $halfPagerSize + 1);
                array_unshift($resultingArray, 0);
                if ($resultingArray[count($resultingArray) - 1] != $numberOfPages) $resultingArray[] = 0;
                return $resultingArray;
            }
        }
    }

    /**
     * @param $currentPage
     * @param $numberOfBlocks
     * @param $sitePage
     * @return string[]
     */
    public function getPages($currentPage, $numberOfBlocks, $sitePage): array
    {
        if ($numberOfBlocks % self::getNumberOfBlocks() != 0)
            $numberOfPages = intdiv($numberOfBlocks, self::getNumberOfBlocks()) + 1;
        else
            $numberOfPages = intdiv($numberOfBlocks, self::getNumberOfBlocks());
        if ($this->pagerSize >= $numberOfPages) {
            $pages = range(1, $numberOfPages);
            $resultingArray = [];
            foreach ($pages as $value) {
                $resultingArray[] = "<a href=\"$sitePage?page=${value}\">${value}</a>";
            }
        } else {
            $pages = $this->getNeighbor($currentPage, $this->pagerSize, $numberOfPages);
            $resultingArray = [];
            foreach ($pages as $key => $value) {
                if ($value == 0 and $key == 0) {
                    $counter = $pages[1] - 1;
                    $resultingArray[] = "<a href=\"$sitePage?page=${counter}\">...</a>";
                } elseif ($value == 0 and $key == count($pages) - 1) {
                    $counter = $pages[count($pages) - 2] + 1;
                    $resultingArray[] = "<a href=\"$sitePage?page=${counter}\">...</a>";
                } else {
                    $resultingArray[] = "<a href=\"$sitePage?page=${value}\">${value}</a>";
                }
            }
        }
        return $resultingArray;
    }

    public static function getNumberOfBlocks(): int
    {
        if (!self::$configuration)
            self::$configuration = require '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Kernel/ConfigurationFiles/Pager.php';
        return self::$configuration['numberOfBlocksOnPage'];
    }

    private function configurePager($configuration)
    {
        if (!self::$configuration)
            self::$configuration = $configuration;
        $this->pagerSize = self::$configuration['numberOfPages'];
    }
}