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

class UniteHCarouselModelSlider extends UniteHCarModel{
	
	public function getTable($type = 'Sliders', $prefix = 'UniteHCarouselTable', $config = array())
	{
		$table = JTable::getInstance($type, $prefix, $config);
		return $table;
	}
	
	
	/**
	 * 
	 * get item override
	 */
	public function getItem($pk = null){
		$item = parent::getItem($pk);
		
		if(property_exists($item, "visual") && is_array($item->visual) == false){
			$registry = new JRegistry();
			$registry->loadString($item->visual,'JSON');
			$item->visual = $registry->toArray();						
		}
		
		return($item);
	}	

	
	/**
	 * 
	 * get the form
	 */
	public function getForm($data = array(), $loadData = true)
	{
		
		jimport('joomla.form.form');
		
		// Get the form.
		$form = $this->loadForm('com_unitehcarousel.slider', 'slider', array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form)) {
			return false;
		}
		
		return $form;
	}
	
	/**
	 * 
	 * load the form data
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.		
		$data = JFactory::getApplication()->getUserState('com_unitehcarousel.edit.slider.data', array());
		
		if (empty($data)) {
			$data = $this->getItem();
		}
		
		return $data;
	}
	
	
	/**
	 * 
	 * prepare table for saving
	 */
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
				$db->setQuery('SELECT MAX(ordering) FROM #__unitehcarousel_sliders');
				$max = $db->loadResult();

				$table->ordering = $max+1;
			}
		}
		
	}
	
	
}
