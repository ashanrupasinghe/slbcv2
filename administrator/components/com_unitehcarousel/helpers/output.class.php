<?php
// No direct access.
defined('_JEXEC') or die;

	class UniteHCarOutput{
		
		private static $counter = 0;
		
		private $sliderID;
		private $slider;
		private $params;
		private $width;
		private $widthScrolling;
		private $slideWidth;
		private $slideHeight;
		private $visibleAreaWidth;
		private $height;
		private $arrSlides;
		private $sliderJSID;
		private $putJSInBody = false;
		private $numItems;
		private $showArrows;
		private $space;
		private $scrollingPadLeft;		
		
		//css settings.
		private $numSlides;
		private $bulletsSet;
		
		/**
		 * 
		 * output error message
		 */
		private function outputErrorMessage($message){
			?>
			<div style="width:700px;height:130px;font-size:14px;text-align:center;padding-top:30px;border:1px solid black;">
				<?php echo $message?>
			</div>
			<?php 
		}
		
		
		/**
		 * 
		 * include slider files.
		 */
		private function includeClientFiles(){
			
			//include custom css
			$args = "task=getcss&amp;slider_id=".$this->sliderID."&amp;slider_js_id=".$this->sliderJSID;
			
			$urlCustomCSS = UniteFunctionJoomlaHCar::getUrlComponent($args);
			
			$document = JFactory::getDocument();
			
			//put item js library
			$urlCarouselJS = GlobalsUniteHCar::$urlItemPlugin."jquery.carouFredSel-5.6.2.js";
			
			//dmp($urlCarouselJS);exit();
			
			if($this->putJSInBody == false)		 //put item js in head
				$document->addScript($urlCarouselJS);
			else{								 //put item js in body
				?>
					<script type="text/javascript" src="<?php echo $urlCarouselJS?>"></script>
				<?php
			}
				
			$document->addStyleSheet($urlCustomCSS);
		} 

		
		/**
		 * 
		 * init the slider, set all class vars
		 */
		private function initSlider($sliderID){
			
			//set basic vars
			$this->sliderID = $sliderID;
			$this->slider = HelperUniteHCar::getSlider($sliderID);			
			$this->params = $this->slider["params"];
			
			//set height and width
			$this->width = $this->params->get("width");
			
			if(empty($this->width))
				UniteFunctionsHCar::throwError("The slider should have width var");
			$this->countAttributes();
		}
		
		/**
		 * 
		 * init elements like sildes array that will be used in main output.
		 */
		private function initMainOutput(){
			
			//set js id:
			self::$counter++;
			$this->sliderJSID = "unite_carousel_".$this->sliderID."_".self::$counter;
			
			$this->arrSlides = HelperUniteHCar::getArrSlides($this->sliderID);
		}
		
		/**
		 * 
		 * init css output elements
		 */
		private function initCSSOutput(){
			$this->numSlides = HelperUniteHCar::getNumSlides($this->sliderID);
		}
		
		
		/**
		 * 
		 * tells if the description exists or not
		 */
		private function isDescExists($desc){
			$descText = strip_tags($desc);
			$descText = trim($descText);
			$descText = iconv("UTF-8","UTF-8//IGNORE",$descText);
			
			if(empty($descText) || strlen($descText)<=2)
				return(false);
				
			return(true);
		}
		
		
		/**
		 * 
		 * output the slides
		 */
		private function putSlides(){
			
			$imageWidth = $this->params->get("image_width",150);
			$imageHeight = (int)$this->params->get("image_height");
			
			foreach($this->arrSlides as $slide):
				
				$slideParams = $slide["params"];
				$slideImage = $slideParams->get("image");
				$activateLink = trim($slideParams->get("activate_link","no"));
				$openIn = $slideParams->get("link_open_in","new");				
				$htmlTarget = ($openIn == "new")?'target="_blank"':'';				
				$link = $slideParams->get("link","javascript:void(0)");
				$urlImageReized = UniteFunctionJoomlaHCar::getImageOutputUrl($slideImage,$imageWidth,$imageHeight,true);
				
				?>
				<li>
					<?php if($activateLink == "yes"): ?>
					<a href='<?php echo $link?>' <?php echo $htmlTarget?>>
					<?php endif?>
						<img width="<?php echo $imageWidth?>" alt="slide image" height="<?php echo $imageHeight?>" src="<?php echo $urlImageReized?>" />
					<?php if($activateLink == "yes"): ?>
					</a>
					<?php endif?>
				</li>
				<?php 
			endforeach;
		}
		
		
		/**
		 * 
		 * put the javascript
		 */
		private function putJs(){
			
			$params = $this->params;
			$direction = $params->get("direction","left");
			
			$leftArrowID = "null";			
			$rightArrowID = "null";
			
			if($this->showArrows == true){
				if($direction == "left"){				
					$leftArrowID = "'#left_arrow_{$this->sliderJSID}'";
					$rightArrowID = "'#right_arrow_{$this->sliderJSID}'";
				}
				else{		//switch arrows
					$rightArrowID = "'#left_arrow_{$this->sliderJSID}'";
					$leftArrowID = "'#right_arrow_{$this->sliderJSID}'";					
				}
			}
			
			$scrollItems = (int)$params->get("scroll_items","0");
			if($scrollItems == 0)
				$scrollItems = "null";
			
			?>
			<script type="text/javascript">
				jQuery("document").ready(function(){
					jQuery('#<?php echo $this->sliderJSID?>').carouFredSel({
						circular:true,
						responsive:false,
						infinite:true,
						direction:"<?php echo $direction?>",
						height:null,
						width:<?php echo $this->widthScrolling?>,
						align:"left",
						padding:0,			//global padding around the carousel
						synchronise:null,	//don't know what it is
						cookie:false,
						items:{
							visible:<?php echo $this->numItems?>,
							width:<?php echo $this->slideWidth?>,
							height:<?php echo $this->slideHeight?>
						},
						scroll:{
							fx:"directscroll",
							items:<?php echo $scrollItems?>,
							easing:"<?php echo $params->get("easing","swing")?>",
							duration:<?php echo $params->get("trans_duration","500")?>,
							pauseOnHover:<?php echo $params->get("pause_on_hover","true")?>,
							mousewheel:false,
							wipe:false,
							onBefore:null,
							onAfter:null,
							onEnd:null
						},
						auto:{
							play:true,
							pauseDuration:<?php echo $params->get("pause_duration","2500")?>,
							button:null,	// play / pause button
							delay:0,		//delay before start
							onPauseStart:null,
							onPauseEnd:null,
							onPausePause:null
						},
						prev:{
							button:<?php echo $leftArrowID?>,
							key:null		//"up", "down", "left" or "right"							
						},
						next:{
							button:<?php echo $rightArrowID?>,
							key:null
						},
						pagination:{
							container:null,
							keys:false,
							anchorBuilder:null
						}
						
					});
				});
			</script>
			<?php 
		}
		
		
		/**
		 * put html images preload
		 */
		private function putPreloadImages(){
			
			//arrows hover 
			$hasArrows = $this->params->get("has_arrows");
			$arrPreload = array();
			if($hasArrows != "false"){
				$arrowsSetName = $this->params->get("arrows_set");
				$arrowsSet = HelperUniteHCar::getArrowSet($arrowsSetName);
				if($arrowsSet["has_hover"] == true){
					$arrPreload[] = $arrowsSet["url_left_hover"];
					$arrPreload[] = $arrowsSet["url_right_hover"];
				}				
			}
			
			if(empty($arrPreload))
				return(false);
			
			?>
			<div style="opacity:0;position:absolute;">
			<?php 
			foreach($arrPreload as $imageUrl){
				?>
				<img src="<?php echo $imageUrl?>" alt="preload image">
				<?php 
			}
			?>
			</div>
			<?php 
		}
		
		/**
		 * 
		 * count all the attributes for the carousel output
		 */
		private function countAttributes(){
			
			$params = $this->params;
			
			$imagePadding = (int)$params->get("image_padding",0);
			$borderWidth = (int)$params->get("border_width",0);			
			$space = (int)$params->get("space_between",0);			
			$slideHeight = (int)$params->get("image_height",0);
			$showArrows = ($params->get("show_arrows","true") == "true")?true:false;
			
			$sidesWidth = 0;
			
			//set side width
			if($showArrows == true){
				$arrowType = $params->get("arrow_type"); 
				$arrowSet = HelperUniteHCar::getArrowSet($arrowType);
				
				$arrowWidth = $arrowSet["options"]["width"];
				$arrowHeight = $arrowSet["options"]["height"];
				$arrowsPaddingSide = $params->get("arrows_padding_sides",5);
				
				//count side width
				$sidesWidth = $arrowWidth + $arrowsPaddingSide;
			}
			
			//set slide width and height
			$slideWidth = (int)$params->get("image_width",150);
			
			//include border
			if(!empty($borderWidth)){
				$slideWidth += $borderWidth * 2;
				$slideHeight += $borderWidth * 2;
			}
			
			//include padding
			if(!empty($imagePadding)){
				$slideWidth += $imagePadding * 2;
				$slideHeight += $imagePadding * 2;
			}
			
			//include space between (width only)
			$slideWidth += $space;
						
			$slideAreaWidth = $this->width - $sidesWidth*2;
			
			$numItems = floor( ($slideAreaWidth + $space) / $slideWidth);
			
			if($numItems == 0)
				$numItems = 1;
			
			//set variables
			$this->scrollingPadLeft = ceil($space / 2);
			$this->widthScrolling = $numItems * $slideWidth;
			$this->visibleAreaWidth = $this->widthScrolling - $space;
			$this->space = $space;
			$this->showArrows = $showArrows;
			$this->slideWidth = $slideWidth;
			$this->slideHeight = $slideHeight;
			$this->height = $slideHeight;
			$this->numItems = $numItems;
			
		}
		
		
		/**
		 * 
		 * output slider body
		 */
		private function putBody(){
			$params = $this->params;
			
			//set styles:
			$styleWrapper = "width:{$this->width}px;height:{$this->height}px;";
			$styleInner = "width:{$this->visibleAreaWidth}px;height:{$this->height}px;";
			
			//set wrapper position:
			$position = $params->get("position","center");
			switch($position){
				case "center":
					$styleWrapper .= "margin:0px auto;";
				break;
				case "left":
					$styleWrapper .= "float:left;";
				break;
				case "right":
					$styleWrapper .= "float:right;";
				break;
			}
			
			//set margin left / right
			if($position == "left" || $position == "right"){
				$marginLeft = $params->get("margin_left","0");
				$marginRight = $params->get("margin_right","0");
				$styleWrapper .= "margin-left:{$marginLeft}px;margin-right:{$marginRight}px;";
			}
			
			//set margin top/bottom
			$marginTop = $params->get("margin_top","0");
			$marginBottom = $params->get("margin_bottom","0");
			$styleWrapper .= "margin-top:{$marginTop}px;margin-bottom:{$marginBottom}px;";
			
			$addClearBoth =  $params->get("clear_both","false");
			
			//set visible style
			$styleScrolling = "width:{$this->visibleAreaWidth}px;left:-{$this->scrollingPadLeft}px;";
			
			?>
			
			<!--  Begin "Unite Horizontal Carousel" -->
			<div class="unite-carousel-wrapper" style="<?php echo $styleWrapper?>">
				
				<?php if($this->showArrows):?>
					<div class="unite-carousel-arrows-wrapper" style="<?php echo $styleInner?>"> 
					 	<a id="left_arrow_<?php echo $this->sliderJSID?>" href="javascript:void(0)"></a>
				 <?php endif;?>
				
				<div class="unite-carousel-inner" style="<?php echo $styleInner?>">
					<div class="unite-carousel-scrolling" style="<?php echo $styleScrolling?>">				
						<ul id="<?php echo $this->sliderJSID?>">					
							<?php $this->putSlides(); ?>
						</ul>
					</div>	
				</div>
				
				<?php if($this->showArrows):?>
					   <a href="javascript:void(0)" id="right_arrow_<?php echo $this->sliderJSID?>" ></a>
				   </div>
				<?php endif;?>
				
				<?php //$this->putPreloadImages(); ?>
			</div>
			<?php if($addClearBoth == "true"): ?>
			<div style="clear:both"></div>
			<?php endif;?>
			
			<?php $this->putJs(); ?>			
			 
			<!-- End Unite Horizontal Carousel -->
			<?php 
		}
		
		
		/**
		 * 
		 * put css general styles
		 */
		private function putCss_general(){
			?>
			.unite-carousel-wrapper{
				direction:ltr;
				text-align:left;
				overflow:hidden;
				padding:0px;
				margin:0px;
				position:relative;
			}
			
			.unite-carousel-inner{
				position:relative;
				margin:0px auto;
				overflow:hidden;
			}
			
			.unite-carousel-arrows-wrapper{
				position:relative;
				margin:0px auto;
			}
			
			.unite-carousel-wrapper ul{
				list-style:none;
				padding:0px !important;
				margin:0px !important;
			}
			
			.unite-carousel-wrapper ul li{
				float:left;
			}

			.unite-carousel-wrapper ul li a{
				border:none;
				display:inline;
				background:none;
				padding:0px !important;
				margin:0px !important;
			}
			
			.unite-carousel-scrolling{
				padding:0px;
				margin:0px;
				position:absolute;
			}
			
			<?php 
		}
		
		
		/**
		 * 
		 * put arrows css
		 */
		private function putCss_arrows(){
			$params = $this->params;
			
			$showArrows = ($params->get("show_arrows","true") == "true")?true:false;
			if($showArrows == false)
				return(false);
			
			$arrowType = $params->get("arrow_type");
			$arrowSet = HelperUniteHCar::getArrowSet($arrowType);	
			$hasHover = $arrowSet["has_hover"];
			
			$arrowWidth = $arrowSet["options"]["width"];
			$arrowHeight = $arrowSet["options"]["height"];						
			$arrowsPaddingSide = $params->get("arrows_padding_sides",5);
			
			$verticalTuning = $params->get("arrows_vertical_tuning",0);			
			
			$imageLeft = $arrowSet["url_left"];
			$imageRight = $arrowSet["url_right"];
			
			$posLeft = -$arrowWidth-$arrowsPaddingSide;
			$posRight = $posLeft;
			
			$posVertCenter = floor(($this->height - $arrowHeight) / 2);
			$posVertCenter += $verticalTuning;
			
			?>
			
				#left_arrow_<?php echo $this->sliderJSID?>{
					width:<?php echo $arrowWidth?>px;
					height:<?php echo $arrowHeight?>px;
					background:url('<?php echo $imageLeft?>');
					border:none;
					display:block;
					position:absolute;					
					left:<?php echo $posLeft?>px;
					top:<?php echo $posVertCenter?>px;
					z-index:1000;
				}
			
				#right_arrow_<?php echo $this->sliderJSID?>{
					width:<?php echo $arrowWidth?>px;
					height:<?php echo $arrowHeight?>px;
					background:url('<?php echo $imageRight?>');
					display:block;
					border:none;
					position:absolute;
					top:<?php echo $posVertCenter?>px;
					right:<?php echo $posRight?>px;
					z-index:1001;
				}
				
			<?php

			if($hasHover == true):
				?>
					
				#left_arrow_<?php echo $this->sliderJSID?>:hover{
					background:url('<?php echo $arrowSet["url_left_hover"]?>');
				}

				#right_arrow_<?php echo $this->sliderJSID?>:hover{
					background:url('<?php echo $arrowSet["url_right_hover"]?>');
				}
				
				<?php 
			endif;
			
		}
		
		
		/**
		 * 
		 * put css
		 */
		private function putCss(){
			$params = $this->params;
			
			//set border
			$borderWidth = $params->get("border_width",0);
			$imagePadding = (int)$params->get("image_padding",0);
			
			$strBorder = "";
			$strBorderHover = "";			
			if(!empty($borderWidth)){
				$imageBorderColor = $params->get("border_color","#CACACA");
				$imageBorderColorHover = $params->get("hover_border_color","#CACACA");
				$strBorder = "border:{$borderWidth}px solid {$imageBorderColor};";
				$strBorderHover = "border-color:{$imageBorderColorHover};";
			}
			
			$strPadding = "";
			$strPaddingHover = "";
			if(!empty($imagePadding)){
				$imageBackColor = $params->get("image_back_color","#DCDCDC");
				$imageBackColorHover = $params->get("image_hover_back_color","#DCDCDC");
				$strPadding = "padding:{$imagePadding}px;background-color:{$imageBackColor};";
				$strPaddingHover = "background-color:{$imageBackColorHover};";
			}
			
			header("content-type:text/css");
			$this->putCss_general();
			
			?>
			
			/* specific carousel css */

			#<?php echo $this->sliderJSID?> li{
				padding:0px !important;
				margin:0px !important;
				display:block; 
				width:<?php echo $this->slideWidth?>px;
				text-align:center;
			}
			
			#<?php echo $this->sliderJSID?> li img{
				<?php echo $strBorder.$strPadding?>
			}
			
			#<?php echo $this->sliderJSID?> li a:hover img{
				<?php echo $strBorderHover.$strPaddingHover?>
			}
			
			#<?php echo $this->sliderJSID?> li:first-child{
				margin-left:0px !important;
			}
			
			<?php 
			
			$this->putCss_arrows();
			
		}
		
		
		/**
		 * 
		 * set the js to load from the body
		 */
		public function setJsInBody(){
			$this->putJSInBody = true;
		}
		
		
		/**
		 * 
		 * output the slider
		 * @param $sliderID
		 */
		public function outputSlider($sliderID){
			
			try{
				$this->initSlider($sliderID);				
				$this->initMainOutput();
				$this->putBody();
				$this->includeClientFiles();			
				
			}catch(Exception $e){
				$message = $e->getMessage();
				$this->outputErrorMessage($message);
			}			
		}

		
		/**
		 * 
		 * output the css
		 */
		public function outputCss(){
		
			$sliderID = UniteFunctionsHCar::getGetVar("slider_id");
			$sliderJSID = UniteFunctionsHCar::getGetVar("slider_js_id");
			
			try{
				$this->initSlider($sliderID);
				$this->initCSSOutput();
				$this->sliderJSID = $sliderJSID;
				$this->putCss();
				
			}catch(Exception $e){
				$message = $e->getMessage();
				UniteFunctionsHCar::errorHtmlOutput($message);
			}
		}
		
	}

?>