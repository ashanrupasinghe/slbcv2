<?php

/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @version 1.0.0
 * @author UniteCMS.net
 * @copyright (C) 2012- Unite CMS
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

$currentDir = dirname(__FILE__) . "/";

require_once $currentDir . "helpers/globals.class.php";
require_once $currentDir . "helpers/helper.class.php";
require_once $currentDir . "helpers/output.class.php";
require_once $currentDir . "unitejoomla/includes.php";

$isJoomla3 = UniteFunctionsHCar::isJoomla3();
if ($isJoomla3) {
    require_once dirname(__FILE__) . "/models/model_joomla3.php";
} else {  //joomla 2.5
    require_once dirname(__FILE__) . "/models/model_joomla2.php";
}


//init the globals
GlobalsUniteHCar::init();
UniteFunctionJoomlaHCar::$componentName = GlobalsUniteHCar::COMPONENT_NAME;
?>