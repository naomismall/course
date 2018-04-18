<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Index page</title>
    </head>
    <body>

		<h1>Index page</h1>
		<?php 
		
		
		$xml = file_get_contents('data/XML_BusinessRules.xml', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        $data = simplexml_load_string($xml);

        //$csv = file_get_contents('data/Students.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        
		$counter = 1;
		$students = array();
		//$students = fgetcsv($file, filesize("data/Students.txt"));

		$results = array();
		$rec = array();

		$file = fopen("data/Students.csv","r");
		$i = 0;

		$fields = array('susername','slevel','sdept','sprogramme','sroute');

		while(! feof($file))
		 {
		                $rec = fgetcsv($file, 1000, ";");

		               	$students = array_combine($fields, $rec);
		               	$results[$i] = $students;
		                //print_r($students);
		                $i++;
		  }

		  //print_r($results);

        $i=0;

        $RouteGenerics = array();

        foreach ($data->Routes->Item as $Item) {

        	$Level = '';

        	$Routes = explode(",", $Item->Code);
        	if ($Item->Level) {	
        		$Level = $Item->Level;
        	}
        	$Generics = explode(",", $Item->Generic);

       	foreach ($Routes as $Route) {
        		foreach ($Generics as $Generic) {
	        		// echo $Route, ';';
		        	// if ($Level) echo $Level;

		        	// echo ';', $Generic, '<br>';

		        	$RouteGenerics[$i]["route"] = $Route;
		        	$RouteGenerics[$i]["level"] = $Level;
		        	$RouteGenerics[$i]["generic"] = $Generic;

		        	$i++;

        		}
        	}
        }

                	echo 'username;course1;role1';
                	echo '<br>';

        $j = 0;

        $size = count($RouteGenerics);

        	while ($j <= $size ) {

        	$route = $RouteGenerics[$j]["route"];
        	//echo $route, '<br>';

        	
        	// foreach ($results as $result) {
        	// 	if ($result["sroute"] == $RouteGenerics[$j]["route"]) {
	        // 			echo $result["susername"], ';', $RouteGenerics[$j]["generic"], ';student<br>';
	        // 	}
        	// }

            foreach ($results as $result) {
                if ($RouteGenerics[$j]["level"]) {
                    if (($result["sroute"] == $RouteGenerics[$j]["route"]) and ($result["slevel"] == $RouteGenerics[$j]["level"])) {
                            echo $result["susername"], ';', $RouteGenerics[$j]["generic"], ';student<br>';
                    }
                }
                elseif ($result["sroute"] == $RouteGenerics[$j]["route"]) {                    
                    echo $result["susername"], ';', $RouteGenerics[$j]["generic"], ';student<br>';
                    }
            }





            
        $j ++;

        }

		?>
    </body>
</html>
