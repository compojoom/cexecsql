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

if (JVERSION >= 3)
{
	JHTML::_('bootstrap.tooltip');
	JHtml::_('formbehavior.chosen', 'select');
}
else
{
	JHTML::_('behavior.tooltip');
}

JHTML::_('behavior.multiselect');

$doc = JFactory::getDocument();

// Load bootstrap for J2.5
ExecSQLHelperBasic::bootstrap();

// URL index.php?option=com_execsql&format=raw&view=requests&task=executesql
$doc->addScriptDeclaration('
	jQuery(document).ready( function(){
			var btn = jQuery("#execute");
			btn.click(function(){
				var command = jQuery("#command").val();
				btn.attr("disabled", "disabled");
				jQuery.ajax({
					type: "POST",
					url: "index.php?option=com_execsql&format=raw&view=requests&task=executesql",
					data: {com: command},
					success: function( data ){jQuery("#result").html(data)},
					dataType: "html"
				}).done(function(data){
					btn.removeAttr("disabled");
				});
			});
	});
');
?>
<div class="compojoom-bootstrap">
		<table class="table table-hover">
			<tr>
			<td><?php echo JText::_("COM_EXECSQL_INTRO"); ?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("COM_EXECSQL_COMMAND"); ?>:</td>
			</tr>
			<tr>
				<td><textarea name="command" id="command" rows="8" cols="50" class="input-xxlarge"></textarea></td>
			</tr>
			<tr>
				<td><button class="btn btn-info" id="execute"><?php echo JText::_("COM_EXECSQL_EXECUTE"); ?></button></td>
			</tr>
		</table>
		<div id="result">
		</div>

	<div class="clear"></div>
</div>
<?php
echo ExecSQLHelperBasic::getFooter();
