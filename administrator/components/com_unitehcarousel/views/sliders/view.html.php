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

class UniteHCarouselViewSliders extends JMasterViewHCar
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();		
		parent::display($tpl);
	}
	
	
	/**
	 * 
	 * add toolbar
	 */
	protected function addToolbar()
	{

		$title = JText::_('COM_UNITEHCAROUSEL'). " - ". JText::_('COM_UNITEHCAROUSEL_SLIDERS');
		JToolBarHelper::title($title , 'generic.png');
		
		JToolBarHelper::addNew('slider.add','JTOOLBAR_NEW');
		JToolBarHelper::editList('slider.edit','JTOOLBAR_EDIT');
		JToolBarHelper::deleteList('COM_UNITEHCAROUSEL_SLIDER_APPROVE_DELETE', 'sliders.delete','JTOOLBAR_DELETE');
		JToolBarHelper::divider();
		JToolBarHelper::custom('sliders.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
		JToolBarHelper::custom('sliders.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
		//JToolBarHelper::divider();
		//JToolBarHelper::preferences('com_unitehcarousel', 300, 600);
	}
}