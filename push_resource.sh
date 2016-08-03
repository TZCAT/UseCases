#!/bin/bash
SERVER=http://fhirtest.uhn.ca/baseDstu3

FILES=("CVXTZ-DHIS2IMMUNIZATION.json" "DHIS2IMMUNIZATION.json" "vims_product_list_concept.json" "CVXTZ.json" "vims_product_list_concept.json")

for FILE in "${FILES[@]}"
do
    echo "Uploading $FILE"
    RESOURCE=`grep resourceType $FILE  | awk -F: '{print $2}' |  tr -d '"' | tr -d ',' | sed -e 's/^[[:space:]]*//'`
    ID=`grep -m1 id $FILE  | awk -F: '{print $2}' |  tr -d '"' | tr -d ',' | sed -e 's/^[[:space:]]*//'`
    URL=$SERVER/$RESOURCE/$ID
    echo "\tFound Resource: $RESOURCE"
    curl -H 'Content-Type: application/json+fhir' -X PUT --data-binary @$FILE $URL
done
