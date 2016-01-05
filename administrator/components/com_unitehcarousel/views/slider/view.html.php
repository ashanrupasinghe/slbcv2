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
class UniteHCarouselViewSlider extends JMasterViewHCar
{
	protected $form;
	protected $item;
	protected $state;
	protected $isNew = true;
	
	protected $sap_counter = 0;
	
	
	/**
	 * 
	 * add toolbars
	 */
	protected function addToolbar(){
		
		$title = JText::_('COM_UNITEHCAROUSEL')." - ";
		if($this->isNew)
			$title .= '<small>[ ' . JText::_( 'COM_UNITEHCAROUSEL_NEW' ).' ]</small>'; 
		else 
			$title .= $this->item->title." <small>[".JText::_("COM_UNITEHCAROUSEL_EDIT_SETTINGS")."]</small>";
		
		JToolBarHelper::title($title   , 'generic.png' );
		
		if ($this->isNew){
			// For new records, check the create permission.
			JToolBarHelper::apply('slider.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('slider.save', 'JTOOLBAR_SAVE');
			JToolBarHelper::custom('slider.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			JToolBarHelper::cancel('slider.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::apply('slider.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('slider.save', 'JTOOLBAR_SAVE');
			//JToolBarHelper::custom('slider.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			JToolBarHelper::cancel('slider.cancel', 'JTOOLBAR_CANCEL');
		}

	}
	
	
	
	/**
	 * the main disply function
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		$this->isNew	= ($this->item->id == 0);
		
		if($this->_layout == "default" || $this->_layout == "edit"){
			
			if($this->isNew == false){
				$this->linkEditSlides = HelperUniteHCar::getViewUrl_Items($this->item->id);
			}
		}
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();
			
		parent::display($tpl);
		
	}
	
	
}
