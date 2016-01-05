<?php

/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/


// No direct access.
defined('_JEXEC') or die;
	jimport('joomla.application.component.controller');
	/**
	 * include the unitejoomla library
	 */
	$currentDir = dirname(__FILE__)."/";
	
	require_once $currentDir.'functions.class.php';
	require_once $currentDir.'functions_joomla.class.php';
	require_once $currentDir.'admintable.class.php';
	require_once $currentDir.'image_view.class.php';
	require_once $currentDir.'masterview.class.php';
        $isJoomla3 = UniteFunctionsHCar::isJoomla3();
	if($isJoomla3){
		
		class JControllerHCar extends JControllerLegacy{};
		
		
	}else{		//joomla 2.5
		
                    class JControllerHCar extends JController{};
	}

?>