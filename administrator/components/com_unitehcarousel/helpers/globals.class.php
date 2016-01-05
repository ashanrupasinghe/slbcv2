<?php
// No direct access.
defined('_JEXEC') or die;

	class GlobalsUniteHCar{
		
		const EXTENSION_NAME = "unitehcarousel"; 
		const COMPONENT_NAME = "com_unitehcarousel";
		
		const TABLE_SLIDERS = "#__unitehcarousel_sliders";
		const TABLE_SLIDES = "#__unitehcarousel_slides";
		
		const VIEW_SLIDER = "slider";
		const VIEW_SLIDERS = "sliders";
		const VIEW_ITEMS = "items";
		
		const LAYOUT_SLIDER_GENERAL = "edit";
		const LAYOUT_SLIDER_VISUAL = "visual";

		public static $urlBase;
		public static $urlAssets;
		public static $urlAssetsArrows;
		public static $urlAssetsBullets;
		public static $urlItemPlugin;
		public static $urlImages;
		public static $urlCache;
		
		public static $pathAssets;
		public static $pathComponent;
		public static $pathAssetsArrows;
		public static $pathAssetsBullets;
		public static $pathViews;
		public static $pathBase;
		
		
		/**
		 * 
		 * init globals
		 */
		public static function init(){
			//set global vars
			
			self::$urlBase = JURI::root();
			self::$urlAssets = JURI::root()."media/".self::COMPONENT_NAME."/assets/";
						
			self::$urlAssetsArrows = self::$urlAssets."arrows/";
			self::$urlAssetsBullets = self::$urlAssets."bullets/";
			self::$urlCache = self::$urlBase."cache/".self::COMPONENT_NAME."/";
			
			self::$pathBase = JPATH_SITE."/";
			self::$pathComponent = JPATH_ADMINISTRATOR."/components/".self::COMPONENT_NAME."/";
			self::$pathAssets = GlobalsUniteHCar::$pathComponent."assets/";		
			self::$pathAssetsArrows = GlobalsUniteHCar::$pathAssets."arrows/";
			self::$pathAssetsBullets = GlobalsUniteHCar::$pathAssets."bullets/";
			self::$pathViews = GlobalsUniteHCar::$pathComponent."views/";
			
			self::$urlItemPlugin = self::$urlAssets."fred-carousel/";
		}
		
	}

?>