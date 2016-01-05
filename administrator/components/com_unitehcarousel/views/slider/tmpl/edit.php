<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access.
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Load submenu template, using element id 'submenu' as needed by behavior.switcher

$sliderID = $this->item->id;

try{
	
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'slider.cancel' || document.formvalidator.isValid(document.id('slider-form'))) {
			Joomla.submitform(task, document.getElementById('slider-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_UNITEHCAROUSEL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<div class="m">
<form action="<?php echo JRoute::_('index.php?option=com_unitehcarousel&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="slider-form" class="form-validate">
	
<?php echo $this->loadTemplate('general'); ?>
		
<?php
	HelperUniteHCar::includeView("sliders/tmpl/footer.php");	 
?>
		
	
	<?php echo JHtml::_('sliders.end'); ?>		
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>
</div>
	<script type="text/javascript">
	
		jQuery("document").ready(function(){
			//UniteHCarousel.initSliderView();
		});
		
	</script>
	

<div class="clr"></div>
<div id="div_debug"></div>

<?php
		}catch(Exception $e){
			//show system error
			$message = $e->getMessage();
			$message = str_replace("\\", "/", $message);
			$message = stripslashes($message);
			
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					UniteHCarousel.showSliderViewError('<?php echo $message?>');
				});
			</script>
			<?php 
		} 

?>

