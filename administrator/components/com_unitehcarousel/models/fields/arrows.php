<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('JPATH_BASE') or die;

/**
 * Supports a modal article picker.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class JFormFieldArrows extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'arrows';
	
	
	
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');

		// Build the script.
		$script = array();
		$script[] = '	function onArrowsSelect(data){';
		$script[] = '		UniteAdmin.onArrowsChange(data);';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		// Setup variables for display.
		$html = array();
		
		
		$link = 'index.php?option='.GlobalsUniteHCar::COMPONENT_NAME.'&view=slider&layout=arrows&tmpl=component&settingid='.$this->id;
		
		$buttonType = $this->value;
		
		$arrArrowSet = HelperUniteHCar::getArrowSet($buttonType);
		$arrowName = $arrArrowSet["name"];
		
		$html[] = '<input type="hidden" name="' . $this->name . '" id="' . $this->id . '"' . ' value="'.$this->value.'" />';
		$buttonID = $this->id."-btn";
		
		$desc = UniteFunctionsHCar::getVal($this->element, "description");
		
		// The the arrow
		$imageArrow = $arrArrowSet["url_right"];
		$html[] = '<span class="chooser-image-wrapper"><img id="'.$this->id.'-img" title="'.$arrowName.'" src="'.$imageArrow.'"></span>';
		
		//put select button
		$html[] = '	<a id="'.$buttonID.'" class="modal button-secondary button-chooser" href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 900, y: 450}}">Change</a>';
		
		$html = implode("\n", $html);
		
		return $html;
	}
}
