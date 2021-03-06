<?php
# MantisBT - A PHP based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Columns include file
 * @package MantisBT
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses access_api.php
 * @uses authentication_api.php
 * @uses columns_api.php
 * @uses constant_inc.php
 * @uses current_user_api.php
 * @uses file_api.php
 * @uses form_api.php
 * @uses helper_api.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses print_api.php
 */

if (!defined('MANAGE_COLUMNS_INC_ALLOW')) {
	return;
}

require_api('access_api.php');
require_api('authentication_api.php');
require_api('columns_api.php');
require_api('constant_inc.php');
require_api('current_user_api.php');
require_api('file_api.php');
require_api('form_api.php');
require_api('helper_api.php');
require_api('html_api.php');
require_api('lang_api.php');
require_api('print_api.php');

$t_manage_page = defined('MANAGE_COLUMNS');
$t_account_page = defined('ACCOUNT_COLUMNS');

$t_project_id = helper_get_current_project();

# Calculate the user id to set the configuration for.
if ($t_manage_page) {
	$t_user_id = NO_USER;
} else {
	$t_user_id = auth_get_current_user_id();
}

$t_columns = columns_get_all($t_project_id);
$t_all = implode(', ', $t_columns);

$t_columns = helper_get_columns_to_view(COLUMNS_TARGET_CSV_PAGE, false, $t_user_id);
$t_csv = implode(', ', $t_columns);

$t_columns = helper_get_columns_to_view(COLUMNS_TARGET_VIEW_PAGE, false, $t_user_id);
$t_view_issues = implode(', ', $t_columns);

$t_columns = helper_get_columns_to_view(COLUMNS_TARGET_PRINT_PAGE, false, $t_user_id);
$t_print_issues = implode(', ', $t_columns);

$t_columns = helper_get_columns_to_view(COLUMNS_TARGET_EXCEL_PAGE, false, $t_user_id);
$t_excel = implode(', ', $t_columns);

if ($t_account_page) {
	print_account_menu('account_manage_columns_page.php');
}
?>

<div class="col-md-12 col-xs-12">
	<div class="space-10"></div>

	<div class="widget-box widget-color-blue2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">
				<?php print_icon('fa-columns', 'ace-icon'); ?>
				<?php echo lang_get('manage_columns_config') ?>
			</h4>
		</div>

		<div id="manage-columns-div" class="form-container">
			<form id="manage-columns-form" method="post" action="manage_config_columns_set.php">

				<div class="widget-body">
					<div class="widget-main no-padding">
						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped">
								<fieldset>
									<?php echo form_security_field('manage_config_columns_set') ?>
									<input type="hidden" name="project_id" value="<?php echo $t_project_id ?>" />
									<input type="hidden" name="form_page" value="<?php echo $t_account_page ? 'account' : 'manage'; ?>" />
									<tr>
										<td class="category">
											<?php echo lang_get('all_columns_title') ?>
										</td>
										<td>
											<?php  # Newline after opening textarea tag is intentional, see #25839 
											?>
											<textarea class="form-control" id="all-columns" <?php echo helper_get_tab_index() ?> name="all_columns" readonly="readonly" cols="80" rows="5">
<?php echo $t_all ?>
</textarea>
										</td>
									</tr>
									<tr>
										<td class="category">
											<?php echo lang_get('view_issues_columns_title') ?>
										</td>
										<td>
											<?php  # Newline after opening textarea tag is intentional, see #25839 
											?>
											<textarea class="form-control" id="view-issues-columns" <?php echo helper_get_tab_index() ?> name="view_issues_columns" cols="80" rows="5">
<?php echo $t_view_issues ?>
</textarea>
										</td>
									</tr>
									<tr>
										<td class="category">
											<?php echo lang_get('print_issues_columns_title') ?>
										</td>
										<td>
											<?php  # Newline after opening textarea tag is intentional, see #25839 
											?>
											<textarea class="form-control" id="print-issues-columns" <?php echo helper_get_tab_index() ?> name="print_issues_columns" cols="80" rows="5">
<?php echo $t_print_issues ?>
</textarea>
										</td>
									</tr>
									<tr>
										<td class="category">
											<?php echo lang_get('csv_columns_title') ?>
										</td>
										<td>
											<?php  # Newline after opening textarea tag is intentional, see #25839 
											?>
											<textarea class="form-control" id="csv-columns" <?php echo helper_get_tab_index() ?> name="csv_columns" cols="80" rows="5">
<?php echo $t_csv ?>
</textarea>
										</td>
									</tr>
									<tr>
										<td class="category">
											<?php echo lang_get('excel_columns_title') ?>
										</td>
										<td>
											<textarea class="form-control" id="excel-columns" <?php echo helper_get_tab_index() ?> name="excel_columns" cols="80" rows="5">
<?php echo $t_excel ?>
</textarea>
										</td>
									</tr>
								</fieldset>
							</table>
						</div>
					</div>
					<div class="widget-toolbox padding-8 clearfix">
						<span class="required pull-right"> * <?php echo lang_get('required'); ?></span>
						<?php
						if ($t_account_page) {
							if ($t_project_id == ALL_PROJECTS) { ?>
								<input <?php echo helper_get_tab_index() ?> type="submit" <?php echo helper_get_tab_index() ?> class="btn btn-primary btn-sm btn-white btn-round" name="update_columns_as_my_default" value="<?php echo lang_get('update_columns_as_my_default') ?>" /><?php
																																																																					} else { ?>
								<input <?php echo helper_get_tab_index() ?> type="submit" <?php echo helper_get_tab_index() ?> class="btn btn-primary btn-sm btn-white btn-round" name="update_columns_for_current_project" value="<?php echo lang_get('update_columns_for_current_project') ?>" /><?php

																																																																								}
																																																																							}

																																																																							# All Projects: only if admin can setup global default columns.
																																																																							# Specific Project: can set columns for that.  Switch to All Projects to set for all projects.
																																																																							if ($t_manage_page) { ?>
							<?php
																																																																								if ($t_project_id != ALL_PROJECTS) { ?>
								<input <?php echo helper_get_tab_index() ?> type="submit" class="btn btn-primary btn-sm btn-white btn-round" name="update_columns_as_global_default" value="<?php echo lang_get('update_columns_for_current_project') ?>" /><?php
																																																																								} else if (current_user_is_administrator()) { ?>
								<input <?php echo helper_get_tab_index() ?> type="submit" class="btn btn-primary btn-sm btn-white btn-round" name="update_columns_as_global_default" value="<?php echo lang_get('update_columns_as_global_default') ?>" /><?php
																																																																								} ?>
						<?php
																																																																							} ?>
					</div>
				</div>
		</div>
		</form>
	</div>

	<div class="space-10"></div>

	<div id="manage-columns-copy-div" class="form-container">
		<form id="manage-columns-copy-form" method="post" action="manage_columns_copy.php">
			<fieldset>
				<?php echo form_security_field('manage_columns_copy') ?>
				<input type="hidden" name="project_id" value="<?php echo $t_project_id ?>" />
				<input type="hidden" name="manage_page" value="<?php echo $t_manage_page ?>" />

				<select name="other_project_id" class="input-sm">
					<?php print_project_option_list(null, true, $t_project_id); ?>
				</select>

				<?php  # Skip "Copy From" if the current project is ALL PROJECTS, the current page is management page, and the user is not administrator
				if (!$t_manage_page || ($t_project_id != ALL_PROJECTS) || current_user_is_administrator()) { ?>
					<input type="submit" name="copy_from" class="btn btn-primary btn-sm btn-white btn-round" value="<?php echo lang_get('copy_columns_from') ?>" /><?php
																																								} ?>
				<input type="submit" name="copy_to" class="btn btn-primary btn-sm btn-white btn-round" value="<?php echo lang_get('copy_columns_to') ?>" />
			</fieldset>
		</form>
	</div>

	<?php
	if ($t_account_page) {
	?>
		<div class="space-10"></div>
		<div class="form-container">
			<form method="post" action="manage_config_columns_reset.php">
				<fieldset>
					<?php echo form_security_field('manage_config_columns_reset') ?>
					<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo lang_get('reset_columns_configuration') ?>" />
				</fieldset>
			</form>
		</div>
	<?php
	}
	echo '</div>';
