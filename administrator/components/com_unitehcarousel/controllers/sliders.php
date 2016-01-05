<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class UniteHCarouselControllerSliders extends JControllerAdmin
{
	public function getModel($name = 'Slider', $prefix = 'UniteHCarouselModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		
		return $model;
	}
	
	
}