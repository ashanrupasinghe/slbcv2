<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class UniteHCarouselModelItem extends UniteHCarModel
{
	public function getTable($type = 'Item', $prefix = 'UniteHCarouselTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');
		
		// Get the form.
		$form = $this->loadForm('com_unitehcarousel.item', 'item', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		
		/* not implemented yet
		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data)) {
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('published', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('published', 'filter', 'unset');
		}*/

		return $form;
	}
	
	protected function populateState(){
		
		$table = $this->getTable();
		$key = $table->getKeyName();
		$pk = JRequest::getInt($key);
		
		//dmp($_REQUEST);exit();
		
		return(parent::populateState());
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_unitehcarousel.edit.item.data', array());
				
		if (empty($data)) {
			$data = $this->getItem();
		}
		
		return $data;
	}
	
	
	protected function prepareTableReal(&$table)
	{
		jimport('joomla.filter.output');
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
		$table->alias		= JApplication::stringURLSafe($table->alias);

		if (empty($table->alias)) {
			$table->alias = JApplication::stringURLSafe($table->title);
		}

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (empty($table->ordering)) {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__unitehcarousel_slides');
				$max = $db->loadResult();

				$table->ordering = $max+1;
			}
		}
	}
	
	
	protected function getReorderConditions($table)
	{
		$condition = array();
		return $condition;
	}
	
}
