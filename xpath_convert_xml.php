<?php
	$filexml='rules.xml';
	$list_generics = array();
	if (file_exists($filexml)) {
	    $xml = simplexml_load_file($filexml);
	    echo 'Found xml file';
		$f = fopen('xpath_rules_csv.csv', 'w');

		createCsv($xml, $f);

		fclose($f);
	} else {
		echo 'Cannot find XML file';
	}

    function createCsv($xml,$f)
    {

        foreach ($xml->xpath("Generic" as $item) 
        {

           fputcsv($f, $item);
  
        }
        else
        {
         createCsv($item, $f);
        }
     }