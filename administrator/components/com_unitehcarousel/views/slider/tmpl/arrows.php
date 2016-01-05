<?php

/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No direct access.
defined('_JEXEC') or die;
	
	$arrowsSets = HelperUniteHCar::getArrowsList();
	$settingID = UniteFunctionsHCar::getGetVar("settingid");
?>

<div class="arrows_grid">
	<ul class="arrows_list">
	<?php
		foreach($arrowsSets as $name=>$set){
			$urlLeft = $set["url_left"];
			$urlRight = $set["url_right"];
			?>
				<li>
					<a href="javascript:void(0)" class="link_arrow" id="<?php echo $name?>" title="<?php echo $name?>">
						<span>
							<img src="<?php echo $urlLeft?>" class="arrow_left"></img>
							<img src="<?php echo $urlRight?>" class="arrow_right"></img>
						</span>
					</a>
				</li>
			<?php
		}
	?>
	</ul>
	<div class="clear"></div>
</div>

<script type="text/javascript">

	jQuery("a.link_arrow").click(function(){
		var link = jQuery(this);
		var data = {};
		data.settingID = '<?php echo $settingID?>'; 
		data.url_left = link.find(".arrow_left").attr("src"); 
		data.url_right = link.find(".arrow_right").attr("src");
		data.arrowName = this.id;
		
		window.parent.onArrowsSelect(data);
	});
	
</script>