<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class UniteHCarouselControllerItem extends JControllerForm {
	
	/**
	 * 
	 * get slider id
	 */
	private function setRedirectToSlides(){
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$sliderID = $data["sliderid"];
		$redirectUrl = HelperUniteHCar::getViewUrl_Items($sliderID);
		$this->setRedirect($redirectUrl);
	}
	
	
	/**
	 * 
	 * cancel the slide save
	 */
	public function cancel($key=null){
		
		//bypass direct saving restrictions
		$context = "$this->option.edit.$this->context";
		$recordId = JRequest::getInt("id");
		$this->holdEditId($context, $recordId);
		
		parent::cancel($key);
		$this->setRedirectToSlides();
	}
	
	
	/**
	 * 
	 * save and rediret to the url
	 */
	public function save($key = null, $urlVar = null){
		
		parent::save($key,$urlVar);
		
		
		$task = $this->getTask();
		switch($task){
			case "save":
				$this->setRedirectToSlides();				
			break;
		}
		
		return(false);
	}
	
	
}

?>