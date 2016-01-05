<?php
/**
 * ------------------------------------------------------------------------
 * JA Popup Plugin for J25 & J31
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<a <?php echo $arrData['rel'];?> class="<?php echo $arrData['class']; ?>"  href="<?php echo $arrData['href']; ?>" title="<?php echo $arrData['title'] ?>" ><?php echo $arrData['content'] ?></a>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	jQuery(document).ready(function() {
		(window.japuQuery || window.jQuery)("a.<?php echo $arrData['class']; ?>").fancybox({
			imageScale:<?php echo $arrData['imageScale']?>,
			overlayShow: <?php echo $arrData['overlayShow']; ?>,
			overlayOpacity: <?php echo $arrData['overlayOpacity']; ?>,
			<?php if($arrData['onopen'] != "") echo "onStart: ".$arrData['onopen'].","; ?>
			<?php if($arrData['onclose'] != "") echo "onClosed: ".$arrData['onclose'].","; ?>
			centerOnScroll: <?php echo $arrData['centerOnScroll']; ?>
		});
	});
/* ]]> */
</script>