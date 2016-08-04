# UseCases

## FHIR Servers
* TImR : http://41.86.177.42:8080/fhir

### TImR Samples (JSON)

Count all immunizations: /fhir/Immunization?_count=0&_format=json
Count all immunizations given to Females: /fhir/Immunization?patient.gender=F&_count=0&_format=json
Count all BCG given to Females: /Immunization?patient.gender=F&vaccine-code=19&_count=0&_format=json
Count all OPV0 given to Females May 2016: /Immunization?patient.gender=F&vaccine-code=02&dose-sequence=1&date=le2016-05-31&date=ge2016-05-01&_count=0&_format=json

