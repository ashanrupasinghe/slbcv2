<?php

/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/


	// No direct access.
	defined('_JEXEC') or die;
	
	 $fieldSetOptional = $this->form->getFieldset('optional');
	 $styleImagePreview = "";
?>

			<fieldset class="adminform">
				<legend><?php echo empty($this->item->id) ? JText::_('COM_UNITEHCAROUSEL_NEW') : JText::sprintf('COM_UNITEHCAROUSEL_EDIT', $this->item->id); ?></legend>
				<div class="slide_wrapper_inside">
					<ul class="adminformlist" id="slide_list">
						<li>
							<?php $this->putField("id") ?>
						</li>
						<li>
							<div>
								<?php $this->putField("title") ?>
							</div>
						</li>
						<li>
							<?php $this->putField("sliderid") ?>
						</li>				
						<li>
							<?php $this->putField("published") ?>
						</li>
						<li>
							<div class="clr"></div>
							<hr>
							<div class="clr"></div>
						</li>
						<li>
							<?php $this->putOptionalField("image");?>								
						</li>
						<li>
							<br>
							<div id="image_preview_wrapper" class="image_preview_wrapper" <?php echo $this->imagePreviewStyle?>>	
								<img id="image_preview" src="<?php echo $this->urlPreview?>" alt="slide image">
							</div>
						</li>						
						<li>
							<div class="sap_vert"></div>
						</li>
						<li>
							<?php $this->putOptionalField("activate_link");?>
						</li>				
						<li>
							<?php $this->putOptionalField("link");?>
						</li>
						<li>
							<?php $this->putOptionalField("link_open_in");?>
						</li>
						
						
					</ul>
				
				</div>
			</fieldset>				
