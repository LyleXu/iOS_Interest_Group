<?php

require_once 'php_unit_test.php';

class ConsoleTestRunner extends TestRunner
{
  //////////////////////////////////////////////////////////
  /// Generates the report in Console with short text message.
  //////////////////////////////////////////////////////////
  public function Report()
  {
  	$report = '';
    $end = $this->GetNumberOfTestCaseResults();
    for ($loop = 0; $loop < $end; ++$loop)
    {
      $testCaseResult = $this->GetTestCaseResult($loop);
      $report .= $this->ReportTestCase($testCaseResult);
    }
    return $report;
  }
  
  private function ReportEvent(Event &$event)
  {
  	$report = '';
    $type = $event->GetType();
    
    /*
    if (//EventType::USER_MSG() != $type ||
        //EventType::PASS_MSG() != $type ||
        EventType::FAIL_MSG() == $type)
    {
      $report .= 'Reason: ' . $event->GetReason() . PHP_EOL;
    }
    */
    
    if (EventType::FAIL() == $type ||
        EventType::ERROR() == $type)
    {
    	$report .= 	"\tFailed Message: " . $event->GetMessage() . "\tSee detail" . PHP_EOL . 
    			 	"\tActual Type: " . $event->GetActualType() .
                 	"\tValue: ". $event->GetActualValue() . PHP_EOL .
      			 	"\tComparison Type: " . $event->GetComparisonType() .
                 	"\tValue: " . $event->GetComparisonValue() . PHP_EOL .
    				"\tFile: " . $event->GetFile() . " Line: " . $event->GetLine() . PHP_EOL;
    }
    else if (EventType::EXCEPTION_THROWN() == $type)
    {
    	$report .= "\tException: " . $event->GetReason() . PHP_EOL;
    	$report .= "\t  " . $event->GetMessage() . PHP_EOL;
    }
    
    return $report;
  }
  
  private function ReportTestCase(&$testCaseResult)
  {
    $report = "Test Case:". $testCaseResult->GetName();
    $report .= "\tPassed:\t" . ($testCaseResult->TestPassed() ? 'Yes' : 'No') . PHP_EOL;
    
    $end = $testCaseResult->GetNumberOfEvents();
    for ($loop = 0; $loop < $end; ++$loop)
    {
      $event = $testCaseResult->GetEvent($loop);
      $report .= $this->ReportEvent($event);
    }
	    
    return $report;
  }
  
  public function Run(TestSuite &$suite,
                      $filename = null,
                      $extension = 'txt')
  {
    return parent::Run($suite, $filename, $extension);
  }
}
?>
