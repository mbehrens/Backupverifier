<?php
require_once dirname(__FILE__).'/../bootstrap.php';

//$jobHandler->addJob('Test','/home/marcus/tmp/backuptest')->addTest(new Test_TimeInterval(10));
		
$jobHandler->addJob('Bokforing','/home/behrensgroup/backup/bokforingsdator/')->addTest(new Test_TimeInterval(1500));