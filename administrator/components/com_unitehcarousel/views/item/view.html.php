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
class UniteHCarouselViewItem extends JMasterViewHCar
{
	protected $form;
	protected $item;
	protected $state;
	protected $params;
	protected $urlPreview;
	protected $imagePreviewStyle = "";
	protected $slider;
	protected $isEmpty = true;
	
	/**
	 * 
	 * put some field input and label
	 */
	public function putField($name){
		UniteFunctionJoomlaHCar::putFormField($this->form, $name);
	}
	
	/**
	 * 
	 * put some optional field
	 */
	public function putOptionalField($name){
		UniteFunctionJoomlaHCar::putFormField($this->form, $name,"params");
	}
	
	/**
	 * 
	 * set image style and preview url
	 */
	private function setImage(){
		
		//get slider id
		if(!empty($this->item->id)){
			$sliderID = $this->item->sliderid;
		}else 
			$sliderID = JRequest::getVar("sliderid");		
		
		$slider = HelperUniteHCar::getSlider($sliderID);
		$params = $slider["params"];
				
		$imageHeight = $params->get("image_height",100);
		$imageWidth = $params->get("image_width",150);
		
		$this->slider = $slider;
		
		//put image
		if($this->isEmpty == false){
			$filenameImage = $this->params->get("image");
			$this->urlPreview = UniteFunctionJoomlaHCar::getImageOutputUrl($filenameImage,$imageWidth,$imageHeight,true);
		}else{
			$this->imagePreviewStyle = "style='display:none;'";
		}
		
		//add image pattern to js
		$pattern = UniteFunctionJoomlaHCar::getImageOutputUrl("IMAGE_PLACE",$imageWidth,$imageHeight,true,false);		
		UniteFunctionJoomlaHCar::addScriptDeclaration("var g_imagePattern='$pattern';");
	}

	protected function addToolbar(){
		JRequest::setVar('hidemainmenu', true);
		
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo		= true; //ContactHelper::getActions($this->state->get('filter.category'));
		$sliderTitle = $this->slider["title"];
		
		
		$title = JText::_('COM_UNITEHCAROUSEL').' - '.$sliderTitle;
		
		if($isNew){
			$title .= JText::_( 'COM_UNITEHCAROUSEL_NEW' );
		}else{
			$title .= " <small>[".JText::_('COM_UNITEHCAROUSEL_EDIT_SLIDE')."]</small>";
		}
		
		JToolBarHelper::title($title, 'generic.png' );
		
		// Built the actions for new and existing records.
		if ($isNew)  {
			// For new records, check the create permission.
			//if ($canDo->get('core.create')) {
				JToolBarHelper::apply('item.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('item.save', 'JTOOLBAR_SAVE');
				//JToolBarHelper::custom('item.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			//}

			JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			// Can't save the record if it's checked out.
			if (!$checkedOut) {
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				//if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId)) {
					JToolBarHelper::apply('item.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('item.save', 'JTOOLBAR_SAVE');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					//if ($canDo->get('core.create')) {
						//JToolBarHelper::custom('contact.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					//}
				//}
			}

			// If checked out, we can still save
			//if ($canDo->get('core.create')) {
				JToolBarHelper::custom('item.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			//}

			JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');
		}
	}
	
	
	/**
	 * display function
	 * 
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');		
		$this->state	= $this->get('State');
		
		if(!empty($this->item->id))
			$this->isEmpty = false;
		
		$arrParams = $this->item->get("params");
		
		$this->params = new JRegistry();
		$this->params->loadArray($arrParams);
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
						
		$this->setImage();
		
		$this->addToolbar();
		parent::display($tpl);
	}
	
	
}
