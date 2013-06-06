<?php 


//$submit_url = "https://matt@motoreach.com:BurgessM0404@dev.cartell.ie/secure/xml/findvehicle?registration=07C28478&servicename=XML_Cartell_Motoreach&xmltype=soap12&readingtype=kilometers";

//$data = file_get_contents($submit_url);

//echo htmlentities($data);
$url = 'https://matt%40motoreach.com:BurgessM0404@dev.cartell.ie/secure/xml/findvehicle?registration='.$_GET['registration'].'&servicename=XML_Cartell_Motoreach&xmltype=raw&readingtype=kilometers';
$xml = new SimpleXMLElement(@file_get_contents($url));

//$xml = new SimpleXMLElement(file_get_contents($submit_url));

//echo $xml->Body->
//$xml = json_decode(json_encode((array) simplexml_load_string($data)), 1);
 if ( isset($xml->Vehicle) ){
$c = (array)$xml->Vehicle[0];

/* We go through each property of the vehicle object */
foreach ( $c as $i => $p ){
	if ( !empty($p) && ( !is_numeric($p) || $p > 0 ) ) {
$array[$i]	= $p;
	}
}
} 
header('Content-Type: application/json');
echo json_encode($array);

?>