<?php

// $jsonString = '[{"logEvent":{"eventCreationTime":"2016-07-28T11:10:58.325001Z","eventSource":"MoodleClientFail.terminal.in","flowEvent":"flowDetectedException","flowEventCount":"2","uniqueFlowName":"PRD582BKA.OLR.uk.ac.city.moodle.mainClient","flowEventName":"ServiceFault","msgPayload":{"ServiceFault":{"fault":{"faultName":"uk.ac.city.moodle.mainClient_failed","faultMessage":"RecoverableException: Unhandled exception in plugin method., evaluate, StudentEnrol.GetMoodleIds, java.lang.NullPointerException","faultCode":"MDL100","faultDetail":{"Description":{"ExceptionText":["RecoverableException: Unhandled exception in plugin method., evaluate, StudentEnrol.GetMoodleIds, java.lang.NullPointerException","RecoverableException: Unhandled exception in plugin method, java.lang.NullPointerException, uk.ac.city.moodle.MoodleIDQuery, evaluate, MoodleIDQuery.java"]},"faultPart":[{"EnvDetails":"redacted"},{"RequestPayload":{"StudentModuleEnrol":{"StudentRegistrationNo":"150022606","CourseShortName":"GEN_ETI_2016-17","Role":"student","Action":"add","Moodle":{},"ESB":{"GlobalTransactionId":"17a86beb-5121-4f34-a3d3-1cfdbb8efade"}}}},{"ExceptionList":"redacted"},{"FlowState":{"Detail":"12:10:58.323305 StudentEnrol.PrepareEnrolQuery: Completed initial msg handling"}}]}}}}}}]';


$jsonString = '[{"StudentRegistrationNo":"150022606","CourseShortName":"GEN_ETI_2016-17","Role":"student","Action":"add","Moodle":{},"ESB":{"GlobalTransactionId":"17a86beb-5121-4f34-a3d3-1cfdbb8efade"}}]';
//Decode the JSON and convert it into an associative array.
$jsonDecoded = json_decode($jsonString, true);
 
//Give our CSV file a name.
$csvFileName = 'example.csv';
 
//Open file pointer.
$fp = fopen($csvFileName, 'w');
 
//Loop through the associative array.
foreach($jsonDecoded as $row){
    //Write the row to the CSV file.
    fputcsv($fp, $row);
}
 
//Finally, close the file pointer.
fclose($fp);