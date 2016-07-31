<?php 

class EmailRoute
{
	public $class_name = "EmailRoute";
	public $MSG;
	public $EMAIL;
	
	
	public function __construct($MSG) 
	{
	
	$this->MSG = $MSG;


	}

	//Returns a string representation of the SMS Message
	//Good for debugging purposes

	public function dump() {

	$msg_string = '';

	foreach ($this->MSG as $key => $value)
	{	
	
		$msg_string .= "$key:" . $value . ", ";
	
	}

	return $msg_string;

	}

	//Contains the logic to execute the Route

	public function execute() 
	{
	
	 $this->sendEmail();

	}

	public function setEmail($EMAIL)
	{

		$this->EMAIL = $EMAIL;

	}

	public function sendEmail()
	{

		if (strlen($this->EMAIL) == 0)
		{
	     		error_log("You need to set the email address using the setEmail() function");
			return;

		}
		
		$subject = "Text Message from " . $this->MSG['from'];
		
		if (!mail($this->EMAIL, $subject, $this->MSG['body'])) 
		{
			$error = "The email to $this->EMAIL failed from $this->MSG['from'] with this message: $this->MSG['body']";
			error_log($error);
		}
	}

}

?>
