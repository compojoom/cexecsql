<?php
/**
 * @package    ExecSQL
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       28.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

/**
 * Class ExecSQLModelExec
 *
 * @since  1.0.0
 */
class ExecSQLModelExec extends JModelList
{
	/**
	 * Loads the slides
	 *
	 * @param   string  $ordering   - The ordering
	 * @param   string  $direction  - The direction
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$search = $this->getUserStateFromRequest('com_execsql.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		parent::populateState('n.slidename', 'asc');
	}

	/**
	 * Gets the database query
	 *
	 * @return  JDatabaseQuery
	 */
	protected function getListQuery()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*')->from('#__cadvancedslideshow_slides AS n');

		$orderCol = $this->state->get('list.ordering');
		$orderDir = $this->state->get('list.direction');

		$published = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		$categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id', '');
		$this->setState('filter.category_id', $categoryId);

		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$search = $db->quote('%' . $db->escape($search, true) . '%');
			$query->where('n.title LIKE ' . $search);
		}

		if ($published != "")
		{
			$query->where('published = ' . $published);
		}

		if ($categoryId != "")
		{
			$query->where('galleryid = ' . $categoryId);
		}

		$query->order($orderCol . ' ' . $orderDir);

		return $query;
	}
}
