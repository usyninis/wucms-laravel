<?php

class SitemapTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testMap()
	{
		if($units = Unit::active()->get())
		
		foreach($units as $unit)
		{
		
			$crawler = $this->client->request('GET', $unit->url);

			$this->assertTrue($this->client->getResponse()->isOk());
		}
		
		
		
	}

}
