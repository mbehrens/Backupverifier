<?php
interface Test
{
	/**
	 * @param string $path
	 * @return TestResult
	 */
	public function run($path);
}