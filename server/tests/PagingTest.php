<?php

include_once __DIR__ . "/../inc/config.php";

use PHPUnit\Framework\TestCase;

class PagingTest extends TestCase
{

    private function doPage (int $page, int $pageTotal) : int
    {
        $start = 0;
        $end = 0;
        // calculate the logical end of the pet list in
        // terms of the slot and offset
        if (($start + PETS_PER_PAGE) > $pageTotal) $end = $pageTotal;
        else $end = ($start + PETS_PER_PAGE);

        // loop over all the elements in the array (all 8 values)
        // if the element is for a pet display the pet information
        // and if not display an empty box.
        for ($i = $start; $i < ($start + PETS_PER_PAGE); $i++)
        {
            if ($i < $end)
            {
                // load the pet information from the slot.
                error_log("index " . $i);
            }
            else
            {
                error_log("alt index " . $i);
            }
        }

        return (0);
    }


    public function testPaging1(): void
    {
        $this->doPage(0, 8);
        $this->doPage (1, 1);
    }

}

?>