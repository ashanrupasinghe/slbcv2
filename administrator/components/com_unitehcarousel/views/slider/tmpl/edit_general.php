<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/


// No direct access.
defined('_JEXEC') or die;

	if($this->isNew)
		$boxTitle = JText::_('COM_UNITEHCAROUSEL_NEW');
	else
		$boxTitle = JText::_('COM_UNITEHCAROUSEL_SLIDER_SETTINGS');
		
?>

	<div class="width-60 fltlft">	
		<?php UniteFunctionJoomlaHCar::putHtmlFieldsetBox($this->form, "general", $boxTitle); ?>
		<?php if($this->isNew == false):?>
			<a href="<?php echo $this->linkEditSlides?>" id="button_edit_slides_general" class="button-primary">Edit Slides</a>
		<?php endif;?>
				
	</div> 

	<div class="width-40 fltrt">
		<?php UniteFunctionJoomlaHCar::putHtmlFieldsetBoxes($this->form, "params"); ?>
	</div>
	
	<div class="clr"></div>
	
	