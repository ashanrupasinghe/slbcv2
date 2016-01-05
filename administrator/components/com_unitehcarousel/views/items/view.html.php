<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

class UniteHCarouselViewItems extends JMasterViewHCar
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $arrSliders;
	protected $linkSliderSettings;
	protected $sliderID;
	
	
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		$this->arrSliders = $this->get("ArrSliders");
		$this->sliderID = $this->get("SliderID");
		
		$this->linkSliderSettings = HelperUniteHCar::getViewUrl_Slider($this->sliderID);
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();		
		parent::display($tpl);
	}
	
	
	protected function addToolbar()
	{
		//$sliderTitle = $this->arrSliders[$this->sliderID]["title"];
		$arrSlider = HelperUniteHCar::getSlider($this->sliderID);
		$sliderTitle = $arrSlider["title"];
				
		$title = JText::_('COM_UNITEHCAROUSEL'). " - ".$sliderTitle." - ";
		$title .= "<small>[".JText::_('COM_UNITEHCAROUSEL_SLIDES')."]</small>";
		
		JToolBarHelper::title($title, 'generic.png');
		
		$numSliders = count($this->arrSliders);
		if($numSliders > 0){
			JToolBarHelper::addNew('items.add','JTOOLBAR_NEW');
			JToolBarHelper::deleteList('', 'items.delete','JTOOLBAR_DELETE');
			JToolBarHelper::divider();
			JToolBarHelper::custom('items.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('items.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::cancel('slider.cancel', 'JTOOLBAR_CLOSE');
			
			//JToolBarHelper::divider();
			//JToolBarHelper::preferences('com_unitehcarousel', 300, 600);
		}
		
	}
}