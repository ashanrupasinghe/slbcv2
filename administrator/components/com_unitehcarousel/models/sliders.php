<?php

/**
 * @package Unite Horizontal Carousel for Joomla 1.7-2.5
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class UniteHCarouselModelSliders extends JModelList {

    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'title', 'a.title',
                'alias', 'a.alias',
                'ordering', 'a.ordering',
                'published', 'a.published',
                'access', 'a.access', 'access_level',
            );
        }

        parent::__construct($config);
    }

    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication();

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        $category = $this->getUserStateFromRequest($this->context . '.filter.category', 'filter_category', '');
        $this->setState('filter.category', $category);

        // List state information.
        parent::populateState('a.title', 'asc');
    }

    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.published');
        $id .= ':' . $this->getState('filter.category');

        return parent::getStoreId($id);
    }

    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select("*");
        $query->from('#__unitehcarousel_sliders AS a');

        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('a.published = ' . (int) $published);
        } else if ($published === '') {
            $query->where('(a.published = 0 OR a.published = 1)');
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');

        $order = $orderCol;

        if (!empty($orderDirn))
            $order .= " " . $orderDirn;

        if (!empty($orderCol))
            $query->order($order);

        return $query;
    }

}
