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

jimport('joomla.filter.output');

JHTML::_('behavior.multiselect');

// Load bootstrap in Joomla 2.5
ExecSQLHelperBasic::bootstrap();

if (JVERSION > 2.5)
{
	JHtml::_('formbehavior.chosen', 'select');
}

$listDir = $this->escape($this->state->get('list.direction'));
$listOrder = $this->escape($this->state->get('list.ordering'));
$filterStatus = $this->escape($this->state->get('filter.status'));
?>
<div class="compojoom-bootstrap">
	<form name="adminForm" id="adminForm" method="post"
	      action="<?php echo JRoute::_('index.php?option=com_execsql&view=logs'); ?>">

		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search fltlft btn-group pull-left">
				<label class="filter-search-lbl element-invisible"
				       for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>

				<input type="text" name="filter_search" id="filter_search"
				       value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
				       title="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>"
				       placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>" accept=""
				       class="text" />

			</div>

			<div class="btn-group pull-left hidden-phone">
				<?php if (JVERSION > 2.5) : ?>
					<button class="btn" type="submit"><i class="icon-search"></i></button>
					<button class="btn" type="button"
					        onclick="document.id('filter_search').value='';this.form.submit();"><i
							class="icon-remove"></i>
					</button>
				<?php else : ?>
					<button class="btn" type="submit"
					        style="margin:0"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button class="btn" type="button" style="margin:0"
					        onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
				<?php endif; ?>
			</div>
		</div>

		<div class="clr"></div>

		<div id="editcell">
		<table class="adminlist table table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'COM_EXECSQL_COMMAND', 'cc.command', $listDir, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'cc.id', $listDir, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_EXECSQL_RESULT', 'cc.result', $listDir, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_EXECSQL_DATE', 'cc.app_id', $listDir, $listOrder); ?>
				</th>
				<th><?php echo JTEXT::_("COM_EXECSQL_USER"); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($this->items as $i => $item) :
			?>
				<tr class="row<?php echo $i % 2; ?>">
					<td><?php echo $this->pagination->getRowOffset($i); ?></td>
					<td><?php echo $item->command ?></td>
					<td><?php echo $item->id ?></td>
					<td><?php echo $item->result; ?></td>
					<td><?php echo JFactory::getDate($item->created); ?></td>
					<td><?php echo JFactory::getUser($item->user_id)->username; ?></td>
				</tr>
			<?php
			endforeach;
			?>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="9">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
			</tfoot>
		</table>
		</div>

		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDir; ?>"/>
		<?php echo JHTML::_('form.token'); ?>
	</form>
</div>
<div class="clear"></div>
<?php
// Show footer
echo ExecSQLHelperBasic::getFooter();
