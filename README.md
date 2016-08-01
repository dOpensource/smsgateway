#Simple SMS Gateway - built by dOpenSource and Powered by Flowroute Messaging API

The goal of this quick project is provide a simple framework for routing SMS Messages that you receive from Flowroute - We love them by the way!  Basically, we take a SMS message and route it based on the "to" portion of the message.  We can route the message to one or more classes that execute logic to process the message.  We started this over the weekend and we just have two (2) route classes created:

|Name | Route Class | Purpose|
|-----|-------------|--------|
Ticket Creation using OSTicket | NPFERoute (name will change to reflect the Route) | To allow customers to open a support ticket by sending one of our DID's a SMS
Email  | EmailRoute | This will send the message via email using a predefined email adddress
SMS  | SMSRoute | Will send a reply SMS message back to the person that sent the original message via the gateway.

The EmailRoute and SMSRoute is configured out of the box.  You should just have to configure your email address and Flowroute Access and Secret Keys.  The instuctions below will have you receiving emails whenever someone sends you a SMS using one of your Flowroute DID's.  It will also send you a SMS reply message stating that the SMS message was received and sent via email.  Note, check your junk email if you don't receive the emails.  You will need to setup an authenticated SMTP gateway to prevent that from happening.  

##Installation*

1. Change directory to your web root (i.e. /var/www/html)
2. Execute ```git clone http://github.com:dOpensource/smsgateway.git`
3. cd smsgateway
4. cp /conf/smsgateway.conf /etc/httpd/conf.d/
5. cd flowroute-messaging-php
6. php composer.phar install
7. service httpd restart
8. Test it by going to http://<your server>:<port>  - You should see a welcome message

* Our config has the server sitting on port  9090.  You can change that if you want.  You might have to add a "Listen 9090" to your /etc/httpd/conf/httpd.conf in order to get the server to listen on a port other then 80.


##Setup Flowroute API Gateway URL

Setup the API Gateway URL within the Flowroute portal to point to the URL that's points to your virtual server that we just setup

## Setup the EmailRoute and SMSRoute 

1. Change directory to your web root
2. cd smsgateway
2. vi index.php
2.Change the following fields to reflect your email address, Flowroute Access Key and Flowroute Secret Key.  You can get the Flowroute keys from the Flowroute Portal.

$EmailRoute_email = "";

$SMSRoute_access_key ="";

$SMSRoute_secret_key = "";

They will look something like this after you change them

$EmailRoute_email = "mh@dopensource.com";

$SMSRoute_access_key ="43524234";

$SMSRoute_secret_key = "253f15885fd49e4d7065a61dd7ed4ec3";

3. Save the file
4. Send a test text message from one of your Flowroute DID's. It doesn't matter which one because they are all SMS enabled by default once you enable the API Gateway URL via the Flowroute portal.  Look in the error log of the virtual server if you have any issues.  

Have Fun...we have lots of things that we will be adding to this!  Follow us at http://twitter.com/dopensource
