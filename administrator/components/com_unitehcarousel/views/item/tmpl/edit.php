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
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'item.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	}
</script>


<form action="<?php echo JRoute::_('index.php?option=com_unitehcarousel&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="slide_wrapper">
		<div class="width-100 fltlft">
			<?php
				echo $this->loadTemplate("inside"); 
			?>
		</div>	<!-- width_100 -->
	</div> <!-- slide wrapper -->
	
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>

	<script type="text/javascript">
		jQuery(document).ready(function(){
			UniteHCarousel.initItemView();
		});
	</script>


<div class="clr"></div>

<?php 
	HelperUniteHCar::includeView("sliders/tmpl/footer.php");
?>	 

