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

        $DepartmentGenerics = array();

        foreach ($data->Departments->Item as $Item) {

        	$Level = '';

        	$Departments = explode(",", $Item->Code);
        	if ($Item->Level) {	
        		$Level = $Item->Level;
        	}
        	$Generics = explode(",", $Item->Generic);

       	foreach ($Departments as $Department) {
        		foreach ($Generics as $Generic) {

		        	$DepartmentGenerics[$i]["Department"] = $Department;
		        	$DepartmentGenerics[$i]["level"] = $Level;
		        	$DepartmentGenerics[$i]["generic"] = $Generic;

		        	$i++;

        		}
        	}
        }

                	echo 'username;course1;role1';
                	echo '<br>';

        $j = 0;

        $size = count($DepartmentGenerics);

        	while ($j <= $size ) {

        	$Department = $DepartmentGenerics[$j]["Department"];
  	
        	foreach ($results as $result) {
                if ($DepartmentGenerics[$j]["level"]) {
            		if (($result["sdept"] == $DepartmentGenerics[$j]["Department"]) and ($result["slevel"] == $DepartmentGenerics[$j]["level"])) {
    	        			echo $result["susername"], ';', $DepartmentGenerics[$j]["generic"], ';student<br>';
    	        	}
                }
                elseif ($result["sdept"] == $DepartmentGenerics[$j]["Department"]) {                    
                    echo $result["susername"], ';', $DepartmentGenerics[$j]["generic"], ';student<br>';
                    }
        	}
        $j ++;

        }

		?>
    </body>
</html>