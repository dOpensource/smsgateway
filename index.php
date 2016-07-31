<?php

require('lib/Class.NPFERoute.php');
require('lib/Class.EmailRoute.php');

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

if ($MSG['to'] == "13138878306") {

/* Creates a Ticket in our ticket system
	
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
*/

/* Sends an email with the SMS info to pre-defined email address */

	//Name of the Route class that contains our logic
	$class = "EmailRoute";

	//Use the PHP Reflection API to create an instance of the class
	$reflection_class = new ReflectionClass($class);

	//Set the parameters to be sent to the class, which is the SMS Message we received from Flowroute
	$params = array($MSG);

	//Now - we actually instanciate the class
	$instance = $reflection_class->newInstanceArgs($params);
	
	//Call a Route specific function to set the email address of the person that should receive the text messages
	$instance->setEmail("smsjunk@dopensource.com"); //Make sure to change the email address
	
	//Every Route class has an execute() function that runs the logic for that Route
	$instance->execute();
	
	return;
}

// Catch all - you can add logic to run some default logic if you don't have the 'to' number routed explicitly.

}

?>
