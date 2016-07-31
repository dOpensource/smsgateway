#!/bin/bash

SMSGATEWAY_URL=http://sms.dopensource.com:9091
TO=13138878306
FROM=19485186566

echo curl -H "Content-Type:application/json" -X POST --data \'{"body": "Testing", "to": "$TO", "from": "$FROM", "id": "mdr1-5c142c48afd54516bcf5559f803ee90b"}\' $SMSGATEWAY_URL


