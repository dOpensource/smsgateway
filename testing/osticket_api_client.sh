#!/bin/bash

OSTICKET_API_URL=<OSTICKET_API_URL>
OSTICKET_API_KEY=<OSTICKET_API_KEY>

curl -H Content-Type:application/json -H X-API-Key:$APIKEY -X POST --data '{"alert":"true","autorespond":"true","source":"API","name":"Mack Hendricks","email":"mack@goflyball.com","subject":"Testing API","message":"Testing Message","topicId":"33"}' $OSTICKET_API_URL
