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

        $ProgrammeGenerics = array();

        foreach ($data->Programmes->Item as $Item) {

        	$Level = '';

        	$Programmes = explode(",", $Item->Code);
        	if ($Item->Level) {	
        		$Level = $Item->Level;
        	}
        	$Generics = explode(",", $Item->Generic);

       	foreach ($Programmes as $Programme) {
        		foreach ($Generics as $Generic) {

		        	$ProgrammeGenerics[$i]["Programme"] = $Programme;
		        	$ProgrammeGenerics[$i]["level"] = $Level;
		        	$ProgrammeGenerics[$i]["generic"] = $Generic;

		        	$i++;

        		}
        	}
        }

                	echo 'username;course1;role1';
                	echo '<br>';

        $j = 0;

        $size = count($ProgrammeGenerics);

        	while ($j <= $size ) {

        	$Programme = $ProgrammeGenerics[$j]["Programme"];
  	
        	// foreach ($results as $result) {
        	// 	if ($result["sprogramme"] == $ProgrammeGenerics[$j]["Programme"]) {
	        // 			echo $result["susername"], ';', $ProgrammeGenerics[$j]["generic"], ';student<br>';
	        // 	}

            foreach ($results as $result) {
                if ($ProgrammeGenerics[$j]["level"]) {
                    if (($result["sprogramme"] == $ProgrammeGenerics[$j]["Programme"]) and ($result["slevel"] == $ProgrammeGenerics[$j]["level"])) {
                            echo $result["susername"], ';', $ProgrammeGenerics[$j]["generic"], ';student<br>';
                    }
                }
                elseif ($result["sprogramme"] == $ProgrammeGenerics[$j]["Programme"]) {                    
                    echo $result["susername"], ';', $ProgrammeGenerics[$j]["generic"], ';student<br>';
                    }
            }

        	
        $j ++;

        }

		?>
    </body>
</html>