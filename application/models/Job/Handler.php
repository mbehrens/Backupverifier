<?php
class Job_Handler extends Handler
{
	protected $jobs;
	protected $reportEmails;
	
	public function __construct()
	{
		$this->jobs = array();
		$this->reportEmails = array();
	}
	
	public function addReportEmail($email)
	{
		$email = strtolower($email);
		if(!in_array($email, $this->reportEmails))
			$this->reportEmails[] = $email;
	}
	
	public function addJob($name, $file)
	{
		$job = new Job($name, $file);
		$this->jobs[] = $job;
		return $job;
	}
	
	public function runJobs()
	{
		foreach($this->jobs as $job)
		{
			$failedTests = $job->runTests();
			
			if(is_array($failedTests) AND !empty($failedTests))
			{
				if(!empty($failedTests))
				{
					// Notify admin
					$subject = 'Backup alert! '.$job->getName();
					$body = '';
					foreach($failedTests as $test)
					{
						$body .= $test->getMessage()."\n";
					}
					
					$mail = new Zend_Mail();
					$mail->setBodyText($body);
					$mail->setSubject($subject);
					
					foreach($this->reportEmails as $email)
					{
						$mail->addTo($email);
					}
					$mail->send();
				}
			}
		}
	}
}