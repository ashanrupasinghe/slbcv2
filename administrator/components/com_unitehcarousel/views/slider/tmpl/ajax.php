<?php

/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/


// No direct access.
defined('_JEXEC') or die;

	$action = UniteFunctionsHCar::getPostVariable("action");
	$data = UniteFunctionsHCar::getPostVariable("data");
	$response = array("action"=>$action,"success"=>true);
	
	try{		
		switch($action){
			case "get_bullets_html":
				$setName = UniteFunctionsHCar::getVal($data, "setName");
				$html = HelperUniteHCar::getBulletsHtml($setName);
				$response["bullets_html"] = $html;
			break;
			default:
				UniteFunctionsHCar::throwError("Wrong action: <b>$action</b>");
			break;
		}
	}catch(Exception $e){
		$message = $e->getMessage();		
		UniteFunctionsHCar::jsonErrorResponse($message);
	}
	
	UniteFunctionsHCar::jsonResponse($response);

?>