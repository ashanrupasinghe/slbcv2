<?php
/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/


// No direct access.
defined('_JEXEC') or die;
	
	$bulletsSets = HelperUniteHCar::getBulletsList();
	
?>

<div class="bullets_grid">
	<ul class="bullets_list">
	<?php
		foreach($bulletsSets as $name=>$set){
			$urlPreview = $set["url_preview"];
			
			?>
				<li>
					<a href="javascript:void(0)" class="link_bullet" id="<?php echo $name?>" title="<?php echo $name?>">
						<span>
							<img src="<?php echo $urlPreview?>" class="bullet_default"></img>
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

	jQuery("a.link_bullet").click(function(){
		var link = jQuery(this);
		var setName = this.id;
		
		window.parent.onBulletsSelect(setName);
	});
	
</script>