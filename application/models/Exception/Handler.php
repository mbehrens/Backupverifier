<?php
class Exception_Handler
{
	protected $tmpDir;
	protected $reportInterval;	// In seconds
	protected $sendErrorMail = true;
	protected $lastExceptionText;
	
	public function __construct($tmpDir=null, $reportInterval=null)
	{
		if(!isset($tmpDir))
			$this->tmpDir = sys_get_temp_dir();
			
		if(!isset($reportInterval))
			$this->reportInterval = 2 * 60;
	}
	
	public function setSendErrorMail($sendErrorMail)
	{
		$this->sendErrorMail = $sendErrorMail;
	}
	
	public function handleException(Exception $exception)
	{
		$errorText = $this->getExceptionErrorText($exception);
		
		if(!$this->hasExceptionBeenReported($exception))
		{
			/**
			 * @todo Activate error reporting
			 */
			if($this->sendErrorMail)
				//Email::sendErrorMail($errorText);
				
			$this->createExceptionTempFile($exception);
			$this->lastExceptionText = $errorText;
		}
		
		echo $exception->__toString();
		exit();
		
		return false;
	}
	
	public function getLastExceptionText()
	{
		return $this->lastExceptionText;
	}
	
	protected function getExceptionErrorText(Exception $exception)
	{
		return get_class($exception) . ": " . $exception->getMessage();
	}
	
	protected function getExceptionTempFilename(Exception $exception)
	{
		return $this->tmpDir.'/exp_'.md5(get_class($exception).$exception->getMessage());
	}
	
	public function hasExceptionBeenReported(Exception $exception)
	{
		$filename = $this->getExceptionTempFilename($exception);
		if(file_exists($filename) AND time() - filectime($filename) < $this->reportInterval)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function createExceptionTempFile(Exception $exception)
	{
		$filename = $this->getExceptionTempFilename($exception);
		$this->deleteExceptionTempFile($exception);		
		return file_put_contents($filename, time()) !== false;
	}
	
	public function deleteExceptionTempFile(Exception $exception)
	{
		$filename = $this->getExceptionTempFilename($exception);
		if(file_exists($filename)) @unlink($filename);
	}
}