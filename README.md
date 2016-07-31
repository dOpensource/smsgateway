#Simple SMS Gateway - built by dOpenSource and Powered by Flowroute Messaging API

The goal of this quick project is provide a simple framework for routing SMS Messages that you receive from Flowroute - We love them by the way.  Basically, we take a SMS message and route it based on "to" portion of the message.  We can route the message to one or more classes that execute logic to process the message.  We started this over the weekend and we just have two (2) route classes created:

|Name | Route Class | Purpose|
|-----|-------------|--------|
Ticket Creation using OSTicket | NPFERoute (name will change to reflect the Route) | To allow customers to open a support ticket by sending one of our DID's a SMS
Email SMS | EmailRoute | This will send the message via email using a predefined email adddress

The EmailRoute is configured out of the box.  You just have to give it your email address.  The instuctions below will have you receiving emails whenever someone sends you a SMS using on of your Flowroute DID's.

##Installation

1. Change directory to your web root (i.e. /var/www/html)
2. git clone git@github.com:dOpensource/smsgateway.git
3. cd smsgateway
4. cp /conf/smsgateway.conf /etc/httpd/conf.d/
5. service httpd restart

* Our config has the server sitting on port  9090.  You can change that if you want.  You might have to add a "Listen 9090" to your /etc/httpd/conf/httpd.conf in order to get the server to listen on a port other then 80.


##Setup Flowroute API Gateway URL

Setup the API Gateway URL within Flowroute to point to the URL that's points to your virtual server

## Setup the EmailRoute to use your email address

1. vi index.php
2. Find smsjunk@dopensource.com and replace it with your email address
3. Save the file
4. Send a test text message from one of your Flowroute DID's it doesn't matter which one because they are all SMS enabled by default once you enable the API Gateway URL.

Have Fun...we have lots of things that we will be adding to this!  Follow us at http://twitter.com/dopensource
