<?php
//---------------
//  Facilities - Begin
//---------------

// GET APIs
$route = '/v1/facilities/';
$app->get($route, function ()  use ($app){
				
	// Input parameters
	if(isset($_REQUEST['query'])){ $query = $_REQUEST['query']; } else { $query = '';}
	if(isset($_REQUEST['state'])){ $state = $_REQUEST['state']; } else { $state = '';}
	if(isset($_REQUEST['region'])){ $region = $_REQUEST['region']; } else { $region = '';}
	if(isset($_REQUEST['type'])){ $type = $_REQUEST['type']; } else { $type = '';}
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}

	$facilitiesString = file_get_contents("http://kinlane.github.io/dev-hub/json/facilities.json");
	$facilitiesResult = json_decode($facilitiesString,true);

	$Facilities['facilities'] = array();

	foreach($facilitiesResult['facilities'] as $facility)
		{
		$IncludeRecord = true;
		
		$Facility_ID = $facility['facility_id'];
		$Station_ID = $facility['station_id'];
		$Division = $facility['division'];
		$Name = $facility['name'];
		$Region = $facility['region'];
		$Type = $facility['type'];
		$Address = $facility['address'];
		$City = $facility['city'];
		$State = $facility['state'];
		$Postal_Code = $facility['postal_code'];
		$Phone = $facility['phone'];
		$Fax = $facility['fax'];
		$Latitude = $facility['latitude'];
		$Longitude = $facility['longitude'];
		$Description = $facility['description'];
		$URL = $facility['url'];
		
		if($query!='')
			{
			// Filter by query against any name or description - other fields?
			if(strpos($Name,$query) === FALSE || strpos($Description,$query) === FALSE)
				{
				$IncludeRecord = false;	
				}  
			}
		// filter by state
		if($state!=''){ if($state!=$State){ $IncludeRecord = false;	} }
		
		// filter by region
		if($region!=''){ if($region!=$Region){ $IncludeRecord = false;	} }
		
		// filter by type
		if($type!=''){ if($type!=$Type){ $IncludeRecord = false;	} }							

		if($IncludeRecord==true)
			{
			$F = array();
						
			$F['facility_id'] = $Facility_ID;
			$F['name'] = $Name;
			$F['region'] = $Region;
			$F['type'] = $Type;
			$F['state'] = $State;
			$F['url'] = $URL;
			
			array_push($Facilities['facilities'], $F);				
			}
		}

	$app->response()->header("Content-Type", "application/json");
	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($Facilities)));
		}
	else 
		{
		echo format_json(json_encode($Facilities));
		}

});

// GET api
$route = '/v1/facilities/:id';
$app->get('/v1/facilities/:id', function ($Facility_ID) use ($app) {
	
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}
	
	$facilitiesString = file_get_contents("http://kinlane.github.io/dev-hub/json/facilities.json");
	$facilitiesResult = json_decode($facilitiesString,true);

	$Facility['facilities'] = array();

	foreach($facilitiesResult['facilities'] as $facility)
		{
		$IncludeRecord = false;
		
		$ID = $facility['facility_id'];
		$Station_ID = $facility['station_id'];
		$Division = $facility['division'];
		$Name = $facility['name'];
		$Region = $facility['region'];
		$Type = $facility['type'];
		$Address = $facility['address'];
		$City = $facility['city'];
		$State = $facility['state'];
		$Postal_Code = $facility['postal_code'];
		$Phone = $facility['phone'];
		$Fax = $facility['fax'];
		$Latitude = $facility['latitude'];
		$Longitude = $facility['longitude'];
		$Description = $facility['description'];
		$URL = $facility['url'];
		
		if($Facility_ID==$ID){ $IncludeRecord = true; }

		if($IncludeRecord==true)
			{
			$F = array();
						
			$F['facility_id'] = $ID;
			$F['station_id'] = $Station_ID;
			$F['division'] = $Division;
			$F['name'] = $Name;
			$F['region'] = $Region;
			$F['type'] = $Type;
			$F['address'] = $Address;
			$F['city'] = $City;
			$F['state'] = $State;
			$F['postal_code'] = $Postal_Code;
			$F['phone'] = $Phone;
			$F['fax'] = $Fax;
			$F['latitude'] = $Latitude;
			$F['longitude'] = $Longitude;
			$F['description'] = $Description;
			$F['url'] = $URL;
			
			array_push($Facility['facilities'], $F);
			}
		}	

	$app->response()->header("Content-Type", "application/json");
	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($Facility)));
		}
	else 
		{
		echo format_json(json_encode($Facility));
		}
			
});


// GET api
$route = '/v1/facilities/types/';
$app->get($route, function ()  use ($app){
	
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}

	$facilitTypeString = file_get_contents("/var/www/html/repos/va-developer/data/facility-type.json");
	$facilityTypeResult = json_decode($facilitTypeString,true);
	
	$FacilityTypes['facility_types'] = array();
	
	foreach($facilityTypeResult['facility_types'] as $facility)
		{
		$IncludeRecord = true;
		
		$Type = $facility['type'];
		
		$F = array();
					
		$F['type'] = $Type;
		
		array_push($FacilityTypes['facility_types'], $F);
		}	
	
	$app->response()->header("Content-Type", "application/json");
	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($FacilityTypes)));
		}
	else 
		{
		echo format_json(json_encode($FacilityTypes));
		}	
});

//---------------
//  Facilities - End
//---------------	
?>