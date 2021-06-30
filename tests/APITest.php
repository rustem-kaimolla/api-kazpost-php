<?php

namespace Test\KazPost;

use phpDocumentor\Reflection\Types\Array_;
use PHPUnit\Framework\TestCase;
use RustemKaimolla\KazPost\KazPostAPI;

class APITest extends TestCase
{
    public function test__construct()
    {

    }


    public function test__get()
    {
        $api = new KazPostAPI();
        $track_code = "CC016695190KZ";
        $track_code_false = "C0016695190KZ";

        $this->assertSame("BOXISS", $api->get($track_code)->status_code);
        $this->assertNull($api->get($track_code_false)->status_code);
    }

    public function test__get_data()
    {
        $api = new KazPostAPI();
        $track_code = "CC016695190KZ";

        $this->assertIsArray($api->get($track_code)->get_data());
    }
}
