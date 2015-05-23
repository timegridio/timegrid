<?php

class BootstrapperTest extends TestCase {

	/**
	 * Tests that Bootstrapper is installed and working
	 *
	 * @return void
	 */
	public function testButtonGeneration()
	{
		$button = Button::success('Test');

		$this->assertEquals("<button type='button' class='btn btn-success'>Test</button>", $button);
	}

}
