<?php
	$filexml='rules.xml';
	$list_generics = array();
	if (file_exists($filexml)) {
	    $xml = simplexml_load_file($filexml);
	    echo 'Found xml file';
		$f = fopen('rules_csv.csv', 'w');

		createCsv($xml, $f);

		fclose($f);
	} else {
		echo 'Cannot find XML file';
	}

    function createCsv($xml,$f)
    {

        foreach ($xml->children() as $item) 
        {

           $hasChild = (count($item->children()) > 0)?true:false;

        if( ! $hasChild)
        {
        	//$put_arr = array($item->getName(),$item); 
           $put_arr = array($item); 
           if ($item->getName() == 'Generic') {
           		//fputcsv($f, $put_arr ,',','"');
           		fputcsv($f, $put_arr);
           }           
        }
        else
        {
         createCsv($item, $f);
        }
     }

    }













?>