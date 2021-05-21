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
 * Timeline event class for users monitoring issues.
 * @copyright Copyright 2014 MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 * @package MantisBT
 */

/**
 * Timeline event class for users monitoring issues.
 *
 * @package MantisBT
 * @subpackage classes
 */
class IssueMonitorTimelineEvent extends TimelineEvent
{
	private $issue_id;
	private $monitor;

	/**
	 * @param integer $p_timestamp Timestamp representing the time the event occurred.
	 * @param integer $p_user_id   A user identifier.
	 * @param integer $p_issue_id  A issue identifier.
	 * @param boolean $p_monitor   Whether issue was being monitored or unmonitored.
	 */
	public function __construct($p_timestamp, $p_user_id, $p_issue_id, $p_monitor)
	{
		parent::__construct($p_timestamp, $p_user_id);

		$this->issue_id = $p_issue_id;
		$this->monitor = $p_monitor;
	}

	/**
	 * Returns html string to display
	 * @return string
	 */
	public function html()
	{
		$t_string = $this->monitor ? lang_get('timeline_issue_monitor') : lang_get('timeline_issue_unmonitor');

		$t_html = $this->html_start('fa-eye');
		$t_html .= '<div class="action">' . sprintf($t_string, prepare_user_name($this->user_id), string_get_bug_view_link($this->issue_id)) . '</div>';
		$t_html .= $this->html_end();

		return $t_html;
	}
}
