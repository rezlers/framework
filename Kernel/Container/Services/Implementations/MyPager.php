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
     * @param $numberOfPages
     * @param $sitePage
     * @return string[]
     */
    public function getPages($currentPage, $numberOfPages, $sitePage): array
    {
        if ($this->pagerSize >= $numberOfPages) {
            $pages = range(1, $numberOfPages);
            $resultingArray = [];
            foreach ($pages as $value) {
                $resultingArray[] = "<a href=\"$sitePage.php?page=${value}\">...</a>";
            }
        } else {
            $pages = $this->getNeighbor($currentPage, $this->pagerSize, $numberOfPages);
            $resultingArray = [];
            foreach ($pages as $key => $value) {
                if ($value == 0 and $key == 0) {
                    $counter = $resultingArray[1] - 1;
                    $resultingArray[] = "<a href=\"$sitePage.php?page=${counter}\">...</a>";
                } elseif ($value == 0 and $key == count($resultingArray) - 1) {
                    $counter = $resultingArray[count($resultingArray) - 2] + 1;
                    $resultingArray[] = "<a href=\"$sitePage.php?page=${counter}\">...</a>";
                } else {
                    $resultingArray[] = "<a href=\"$sitePage.php?page=${value}\">${value}</a>";
                }
            }
        }
        return $resultingArray;
    }

    private function configurePager($configuration)
    {
        $this->pagerSize = $configuration['pagerSize'];
    }
}