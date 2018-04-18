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
       
		$students = array();
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
				$i++;
			}

        $i=0;

        $SchoolGenerics = array();

        foreach ($data->Schools->Item as $Item) {

        	$Level = '';

        	$Schools = explode(",", $Item->Code);
        	if ($Item->Level) {	
        		$Level = $Item->Level;
        	}
        	$Generics = explode(",", $Item->Generic);

       	foreach ($Schools as $School) {
        		foreach ($Generics as $Generic) {

		        	$SchoolGenerics[$i]["school"] = $School;
		        	$SchoolGenerics[$i]["level"] = $Level;
		        	$SchoolGenerics[$i]["generic"] = $Generic;

		        	$i++;

        		}
        	}
        }

                	echo 'username;course1;role1';
                	echo '<br>';

        $j = 0;

        $size = count($SchoolGenerics);

        	while ($j <= $size ) {

        	$School = $SchoolGenerics[$j]["school"];
  	
        	// foreach ($results as $result) {

        	// 	$CapSchool = substr($result["sdept"],0,1);

        	// 	if ($CapSchool == $School) {
	        // 			echo $result["susername"], ';', $SchoolGenerics[$j]["generic"], ';student<br>';
	        // 	}
        	// }


        	foreach ($results as $result) {

			$CapSchool = substr($result["sdept"],0,1);

                if ($SchoolGenerics[$j]["level"]) {
            		if (($substr($result["sdept"],0,1) == $SchoolGenerics[$j]["school"]) and ($result["slevel"] == $SchoolGenerics[$j]["level"])) {
    	        			echo $result["susername"], ';', $SchoolGenerics[$j]["generic"], ';student<br>';
    	        	}
                }
                elseif ($CapSchool == $School) {                    
                    echo $result["susername"], ';', $SchoolGenerics[$j]["generic"], ';student<br>';
                    }
        	}





        $j ++;

        }

		?>
    </body>
</html>