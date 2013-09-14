<?php

//---------------
//  Press - Begin
//---------------

// GET Press Releases 
$route = '/v1/press/';
$app->get($route, function ()  use ($app){
				
	// Input parameters
	if(isset($_REQUEST['query'])){ $query = $_REQUEST['query']; } else { $query = '';}
	if(isset($_REQUEST['date-start']))
		{
		$datestart = $_REQUEST['date-start']; 
		$datestart = date('Y-m-d H:i:s',strtotime($datestart));	 
		} 
	else 
		{
		$datestart = '';
		}
	if(isset($_REQUEST['date-end']))
		{
		$dateend = $_REQUEST['date-end'];
		$dateend = date('Y-m-d H:i:s',strtotime($dateend)); 
		} 
	else 
		{
		$dateend = '';
		}
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}

	$PressText = file_get_contents("http://kinlane.github.io/dev-hub/json/press.json");
	$PressResult = json_decode($PressText,true);

	$Press['press'] = array();
	
	foreach($PressResult['press'] as $press)
		{
			
		$IncludeRecord = true;
		
		$ID = $press['press_id'];
		$Title = $press['title'];
		$Body = $press['body'];
		$Post_Date = $press['post_date'];
		$Post_Date = date('Y-m-d H:i:s',strtotime($Post_Date));
	
		if($query!='')
			{
			// Filter by query against any name or description - other fields?
			if(strpos($Title,$query) === FALSE || strpos($Body,$query) === FALSE)
				{
				$IncludeRecord = false;	
				}  				
			}			
		if($datestart!='' && $dateend !='')
			{
			// Check if between the dates
			if($Post_Date >= $datestart && $Post_Date <= $dateend)
				{
				$IncludeRecord = true;	
				} 
			else 
				{
				$IncludeRecord = false;	
				} 				
			}	

		if($IncludeRecord==true)
			{	
			$F = array();
						
			$F['press_id'] = $ID;
			$F['title'] = $Title;
			$F['post_date'] = $Post_Date;
			
			array_push($Press['press'], $F);
			}
		}	
	
	$app->response()->header("Content-Type", "application/json");
	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($Press)));
		}
	else 
		{
		echo format_json(json_encode($Press));
		}
});

// GET api
$route = '/v1/press/:id';
$app->get('/v1/press/:id', function ($Press_ID) use ($app) {
	
	if(isset($_REQUEST['callback'])){ $callback = $_REQUEST['callback']; } else { $callback = '';}

	$PressText = file_get_contents("http://kinlane.github.io/dev-hub/json/press.json");
	$PressResult = json_decode($PressText,true);

	$Press['press'] = array();
	
	foreach($PressResult['press'] as $press)
		{
			
		$IncludeRecord = false;
		
		$ID = $press['press_id'];
		$Title = $press['title'];
		$Body = $press['body'];
		$Post_Date = $press['post_date'];
		$Post_Date = date('Y-m-d H:i:s',strtotime($Post_Date));
		
		if($Press_ID==$ID)
			{
			$IncludeRecord=true;	
			}

		if($IncludeRecord==true)
			{	
			$F = array();
						
			$F['press_id'] = $ID;
			$F['title'] = $Title;
			$F['post_date'] = $Post_Date;
			$F['body'] = $Body;
			
			array_push($Press['press'], $F);
			}		
		}	
		
	$app->response()->header("Content-Type", "application/json");
	if(isset($_REQUEST['callback']))
		{
		echo sprintf("%s(%s)", $callback, prettyPrint(json_encode($Press)));
		}
	else 
		{
		echo format_json(json_encode($Press));
		}
				
});

//---------------
//  Press - End
//---------------	
?>