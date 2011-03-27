<?php
class Job
{
	protected $name;
	protected $path;
	protected $tests;
	
	public function __construct($name, $path)
	{
		$this->name = $name;
		$this->path = $path;
		$this->tests = array();
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function addTest(Test $test)
	{
		$this->tests[] = $test;
	}
	
	public function runTests()
	{
		$failedTests = array();
		foreach($this->tests as $test)
		{
			$testResult = $test->run($this->path);
			
			if($testResult instanceof TestResult_Failure)
				$failedTests[] = $testResult;
		}
		
		return $failedTests;
	}
}