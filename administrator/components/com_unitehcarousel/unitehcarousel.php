<?php

/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

$currentDir = dirname(__FILE__) . "/";

require_once $currentDir . "includes.php";

//error_reporting(E_ALL); // debug
// Include dependancies
jimport('joomla.application.component.controller');
if (UniteFunctionsHCar::isJoomla3()) {
    $controller = JControllerLegacy::getInstance(GlobalsUniteHCar::EXTENSION_NAME);
} else {
    $controller = JController::getInstance(GlobalsUniteHCar::EXTENSION_NAME);
}
// Perform the Request task
$task = JFactory::getApplication()->input->get('task');

$controller->execute($task);
$controller->redirect();
?>