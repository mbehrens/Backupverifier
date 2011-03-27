<?php
/**
 * Checks that the latest backup is not older than given time
 *
 */
class Test_TimeInterval implements Test
{
	protected $maxFileAgeInMinutes;
	
	public function __construct($maxFileAgeInMinutes)
	{
		$this->maxFileAgeInMinutes = $maxFileAgeInMinutes;
	}
	
	public function run($path)
	{
		$command = "find $path -mmin -".$this->maxFileAgeInMinutes;
		ob_start();
		passthru($command, $result);
		$output = ob_get_contents();
		ob_end_clean();
		
		if(trim($output) == '')
		{
			return new TestResult_Failure($path.' No new files have been written for over '.$this->maxFileAgeInMinutes.' minutes!');
		}
		
		return true;
	}
}