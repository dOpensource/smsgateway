<?php 

$INC_DIR = $_SERVER["DOCUMENT_ROOT"] ."/"; 

require_once($INC_DIR . 'flowroute-messaging-php/vendor/autoload.php');
include_once($INC_DIR . 'flowroute-messaging-php/src/Controllers/MessagesController.php');
include_once($INC_DIR . 'flowroute-messaging-php/src/Configuration.php');
include_once($INC_DIR . 'flowroute-messaging-php/src/Models/Message.php');
include_once($INC_DIR . 'flowroute-messaging-php/src/APIHelper.php');
include_once($INC_DIR . 'flowroute-messaging-php/src/APIException.php');


use FlowrouteMessagingLib\Controllers\MessagesController;
use FlowrouteMessagingLib\Models\Message;

class SMSRoute
{
	public $class_name = "SMSRoute";
	public $MSG;     //An associative array of the message components that we received from the gateway 
	public $MESSAGE; //The message that you want to send
        public $ACCESS_KEY;
	public $SECRET_KEY;	
	
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
	
	 $this->sendMessage();

	}

	public function setMessage($MESSAGE)
	{

		$this->MESSAGE = $MESSAGE;

	}


	public function setAPIKeys($ACCESS_KEY,$SECRET_KEY) 
	{
	
		$this->ACCESS_KEY=$ACCESS_KEY;
		$this->SECRET_KEY=$SECRET_KEY;

	}

	public function sendMessage()
	{

		if (strlen($this->MESSAGE) == 0)
		{
	     		error_log("You need to set the message you want to send using the setMessage() function");
			return;

		}
		
		if ((!$this->ACCESS_KEY) ||  (!$this->SECRET_KEY))
		{
	     		error_log("You need to set Access and Secret Keys using the setAPIKeys() function");
			return;

		}
		
		
		//Using the Flowroute API to send the message	
		// Create a controller

		$controller = new MessagesController($this->ACCESS_KEY, $this->SECRET_KEY);

		// Build our message
		// We are just switching the from and to fields that we received and sending a reply to the message that we received

		$from_number = $this->MSG['to'];
		$to_number = $this->MSG['from'];
		
		$message = new Message($to_number, $from_number, $this->MESSAGE);

		// Send the message
		$response = $controller->createMessage($message);	

		// If NOT successful log the error to the server error log
		if (!$response) 
		{
			$error = "The SMS message to $to_number failed from $from_number  with this message: $this->MESSAGE";
			error_log($error);
		}
	}

}

?>
