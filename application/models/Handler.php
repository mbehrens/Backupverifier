<?php
abstract class Handler
{
	public static function getEnvironment()
	{
		if(defined('APPLICATION_ENVIRONMENT'))
		{
			return APPLICATION_ENVIRONMENT;
		}
		elseif(getenv('APPLICATION_ENV'))
		{
			return getenv('APPLICATION_ENV');
		}
		
		return 'production';
	}
	
	public static function getConfig()
	{
		$config = new Zend_Config_Ini(dirname(__FILE__).'/../configs/application.ini', self::getEnvironment());
		return $config;
	}
}