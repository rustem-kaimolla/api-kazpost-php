<?php

namespace Test\KazPost;

use PHPUnit\Framework\TestCase;
use RustemKaimolla\KazPost\KazPostAPI;

class APITest extends TestCase
{

    public function testGet(): void
    {
        $api = new KazPostAPI();
        $track_code = "CC016695190KZ";
        $track_code_false = "C0016695190KZ";

        $this->assertSame("BOXISS", $api->get($track_code)->status_code);
        $this->assertNull($api->get($track_code_false)->status_code);
    }

    public function testGetData(): void
    {
        $api = new KazPostAPI();
        $track_code = "CC016695190KZ";

        $this->assertIsArray($api->get($track_code)->getData());
    }
	
	public function testGetInbox(): void
	{
		$api = new KazPostAPI();
		$track_code = "CC016695190KZ";

        $inbox = $api->get($track_code)->inbox()->getInbox();
        $this->assertTrue(is_array($inbox) || $inbox === null);
	}
}