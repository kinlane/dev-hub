<?php
//---------------
//  Programs - Begin
//---------------

// GET APIs
$route = '/v1/programs/';
$app->get($route, function ()  use ($app){
				
	// Input parameters
	if(isset($_REQUEST['query'])){ $query = $_REQUEST['query']; } else { $query = '';}
	if(isset($_REQUEST['state'])){ $state = $_REQUEST['state']; } else { $state = '';}
	if(isset($_REQUEST['type'])){ $type = $_REQUEST['type']; } else { $type = '';}
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}

	$programText = file_get_contents("http://kinlane.github.io/dev-hub/json/programs.json");
	$programResult = json_decode($programText,true);

	$Programs['programs'] = array();

	foreach($programResult['programs'] as $program)
		{
		$IncludeRecord = true;
	
		$P = array();
					
		$ID = $program['program_id'];
		$Facility_ID = $program['facility_id'];
		$Facility_Name = $program['facility_name'];
		$Program_Name = $program['program_name'];
		$Type = $program['type'];
		$State = $program['state'];
		
		if($query!='')
			{
			// Filter by query against any name or description - other fields?
			if(strpos($Program_Name,$query) === FALSE)
				{
				$IncludeRecord = false;	
				}  
			}
		// filter by state
		if($state!=''){ if($state!=$State){ $IncludeRecord = false;	} }
		
		// filter by type
		if($type!=''){ if($type!=$Type){ $IncludeRecord = false;	} }			

		if($IncludeRecord==true)
			{
			$P = array();
						
			$P['program_id'] = $ID;
			$P['facility_id'] = $Facility_ID;
			$P['facility_name'] = $Facility_Name;
			$P['program_name'] = $Program_Name;
			$P['type'] = $Type;
			$P['state'] = $State;
			
			array_push($Programs['programs'], $P);				
			}
		}	
	
	$app->response()->header("Content-Type", "application/json");
	
	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($Programs)));
		}
	else 
		{
		echo format_json(json_encode($Programs));
		}	

});

// GET api
$route = '/v1/programs/types/';
$app->get($route, function ()  use ($app){
		
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}

	$programTypeText = file_get_contents("http://kinlane.github.io/dev-hub/json/program-type.json");
	$programType = json_decode($programTypeText,true);

	$ProgramTypes['program_types'] = array();

	foreach($programType['program_types'] as $programtypes)
		{
		
		$Type = $programtypes['type'];
	
		$P = array();
					
		$P['type'] = $Type;
		
		array_push($ProgramTypes['program_types'], $P);
		}	
	
	$app->response()->header("Content-Type", "application/json");

	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($ProgramTypes)));
		}
	else 
		{
		echo format_json(json_encode($ProgramTypes));
		}		
	
});

// GET api
$route = '/v1/programs/:id/';
$app->get('/v1/programs/:id/', function ($Program_ID) use ($app) {
		
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}

	$programText = file_get_contents("http://kinlane.github.io/dev-hub/json/programs.json");
	$programResult = json_decode($programText,true);

	$Program['programs'] = array();

	foreach($programResult['programs'] as $programs)
		{
		$IncludeRecord = false;
		
		$ID = $programs['program_id'];
		$Facility_ID = $programs['facility_id'];
		$Facility_Name = $programs['facility_name'];
		$Program_Name = $programs['program_name'];
		$Type = $programs['type'];
		$Address = $programs['address'];
		$City = $programs['city'];
		$State = $programs['state'];
		$Postal_Code = $programs['postal_code'];
		$Phone = $programs['phone'];
		$Contact_Name = $programs['contact_name'];
		$Contact_Phone = $programs['contact_phone'];		
				
		if($Program_ID==$ID){ $IncludeRecord = true; }

		if($IncludeRecord==true)
			{						
			$P = array();
		
			$P['program_id'] = $Program_ID;
			$P['facility_id'] = $Facility_ID;
			$P['facility_name'] = $Facility_Name;
			$P['program_name'] = $Program_Name;
			$P['type'] = $Type;
			$P['address'] = $Address;
			$P['city'] = $City;
			$P['state'] = $State;
			$P['postal_code'] = $Postal_Code;
			$P['phone'] = $Phone;
			$P['contact_name'] = $Contact_Name;
			$P['contact_phone'] = $Contact_Phone;
			
			array_push($Program['programs'], $P);
			}
		}	
	
	$app->response()->header("Content-Type", "application/json");

	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($Program)));
		}
	else 
		{
		echo format_json(json_encode($Program));
		}	
	
});

//---------------
//  Programs - End
//---------------	
?>