<?php 

namespace Json\Commands;

class BaseResponse
{
	public $_returnCode;
	public $_returnMessage;
	
	public function __construct(){
		$this->_returnCode = \Constant\ErrorCode::Failed;
	}
}

?>