<?php 
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('_JEXEC') or die('Restricted access'); ?>

<?php 

	$numSliders = count($this->arrSliders);

	if($numSliders == 0){	//error output
		?>
			<h2>Please add some slider before operating slides</h2>
		<?php 
	}else
		echo $this->loadTemplate("slide");
	
	HelperUniteHCar::includeView("sliders/tmpl/footer.php");	 
		
?>



