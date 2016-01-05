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

class UniteHCarouselControllerItems extends JControllerAdmin
{
	public function getModel($name = 'Item', $prefix = 'UniteHCarouselModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	
	public function add(){
		$sliderID = JRequest::getInt("sliderid");
		
		$view = "item";
		$layout = "edit";
		$option = JRequest::getVar('option');
		
		$redirectUrl = JRoute::_("index.php?option=$option&view=$view&layout=$layout&sliderid=$sliderID",false);
		
		$this->setRedirect($redirectUrl);
	}
	
	/**
	 * 
	 * set redirect url
	 */
	private function setRedirectToSlides(){
		$sliderID = JRequest::getVar("sliderid");
		$redirectUrl = HelperUniteHCar::getViewUrl_Items($sliderID);
		$this->setRedirect($redirectUrl);
	}
	
	/**
	* set redirect after all functions.
	* 
	*/
	public function publish(){		
		parent::publish();
		$this->setRedirectToSlides();
	}
	
	public function reorder(){
		parent::reorder();
		$this->setRedirectToSlides();		
	}
	
	public function delete(){
		parent::delete();
		$this->setRedirectToSlides();		
	}
	
	public function saveorder(){
		parent::saveorder();
		$this->setRedirectToSlides();
	}
	
	public function checkin(){
		parent::checkin();
	}
	
}