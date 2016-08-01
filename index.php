<?php

require('lib/Class.NPFERoute.php');
require('lib/Class.EmailRoute.php');
require('lib/Class.SMSRoute.php');

//TODO - Set these parameters

$EmailRoute_email = "";
$SMSRoute_access_key ="";
$SMSRoute_secret_key = "";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	echo "Simple SMS Gateway - built by dOpenSource and Powered by Flowroute Messaging API";

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$json = file_get_contents("php://input"); 
$obj = json_decode($json);

//Parse the message from Flowoute

$MSG['to'] = $obj->{"to"};
$MSG['from'] = $obj->{"from"};
$MSG['body'] = trim($obj->{"body"});
$MSG['id'] = $obj->{"id"};

//Send the message over for Routing

RouteMessage($MSG);


}

//Route the message

function RouteMessage(&$MSG) {

//Check the to number to see where to route the Messsage

/*
if ($MSG['to'] == "13138878306") {

 Creates a Ticket in our ticket system
	
	//Name of the Route class that contains our logic
	$class = "NPFERoute";

	//Use the PHP Reflection API to create an instance of the class
	$reflection_class = new ReflectionClass($class);

	//Set the parameters to be sent to the class, which is the SMS Message we received from Flowroute
	$params = array($MSG);

	//Now - we actually instanciate the class
	$instance = $reflection_class->newInstanceArgs($params);
	
	//Every Route class has an execute() function that runs the logic for that Route
	$instance->execute();
}

*/



// Catch all - you can add logic to run some default logic if you don't have the 'to' number routed explicitly.
// Sends an email with the SMS info to a pre-defined email address 

	global $EmailRoute_email;
	global $SMSRoute_access_key; 
	global $SMSRoute_secret_key;


	//Name of the Route class that contains our logic
	$class = "EmailRoute";

	//Use the PHP Reflection API to create an instance of the class
	$reflection_class = new ReflectionClass($class);

	//Set the parameters to be sent to the class, which is the SMS Message we received from Flowroute
	$params = array($MSG);

	//Now - we actually instanciate the class
	$instance = $reflection_class->newInstanceArgs($params);
	
	//Call a Route specific function to set the email address of the person that should receive the text messages
	$instance->setEmail($EmailRoute_email); //Make sure to change the email address
	
	//Every Route class has an execute() function that runs the logic for that Route
	$success = $instance->execute();

	//We will instanciate another Route class that will send a confirmation message back 

	$SMSRoute = instanciate("SMSRoute",$MSG);

	// Set the API Keys	
	$SMSRoute->setAPIKeys($SMSRoute_access_key,$SMSRoute_secret_key);

	// We will use the message() function to set the message we want to send	
	if ($success)
		$SMSRoute->setMessage("Your message was forwarded via email.  Some one will contact you shortly");
	else
		$SMSRoute->setMmessage("Your message failed. Please try again later");
	
	// We now execute the route, which in this case will just send the message back using the Flowroute Messaging API
	
	$SMSRoute->execute();

	return;

}

function instanciate($CLASSNAME,&$MSG) {

        //Use the PHP Reflection API to create an instance of the class
        $reflection_class = new ReflectionClass($CLASSNAME);

        //Set the parameters to be sent to the class, which is the SMS Message we received from Flowroute
        $params = array($MSG);

        //Now - we actually instanciate the class
        $instance = $reflection_class->newInstanceArgs($params);

	if ($instance)
		return $instance;
}

?>
