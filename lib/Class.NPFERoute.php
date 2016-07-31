<?php 

class NPFERoute
{
	public $class_name = "NPFERoute";
	public $MSG;
	
	
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
	
	 $this->createTicket();

	}

	public function createTicket() {

	$config = array(
	'url'=>'http://<OSTICKET_API_URL>',
	'key'=>'<OSTICKET_API_KEY'
	);

	$data = array("alert" => "true",
       "autorespond" => "true",
       "source" => "API",
       "name" => "Mack hendricks",
       "email" => "mack@goflyball.com",
       "subject" => "NPFE Support Ticket via Text Message",
       "message" => $this->MSG['body'],
       "topicId" => "33"
	);
	
	#Convert the above array into json to POST to the API with curl below.
	
	$data_string = json_encode($data);

	#curl post
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $config['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.9');
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'X-API-Key: '.$config['key']));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result=curl_exec($ch);
	curl_close($ch);

	if(preg_match('/HTTP\/.* ([0-9]+) .*/', $result, $status) && ($status[1] == 200 || $status[1] == 201))	
		return TRUE;
		
	error_log("New Ticket API Failed Result: " . $result);
	return FALSE;	


	}


}

?>
