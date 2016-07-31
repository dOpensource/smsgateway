#Simple SMS Gateway - built by dOpenSource and Powered by Flowroute Messaging API

The goal of this quick project is provide a simple framework for routing SMS Messages that you receive from Flowroute - We love them by the way.  Basically, we take a SMS message and route it based on "to" portion of the message.  We can route the message to one or more classes that execute logic to process the message.  We started this over the weekend and we just have two (2) route classes created:

|Name | Route Class | Purpose|
|-----|-------------|--------|
Ticket Creation using OSTicket | NPFERoute (name will change to reflect the Route) | To allow customers to open a support ticket by sending one of our DID's a SMS
Email SMS | EmailRoute | This will send the message via email using a predefined email adddress

##Installation

copy /conf/smsgateway.conf to /etc/httpd/conf.d/

Our config has the server sitting on port  9090.  You can change that if you want.

restart/reload the httpd server

##Setup Flowroute API Gateway URL

Setup the API Gateway URL within Flowroute to point to the URL that's points to your virtual server

## Send a Test Text Message
