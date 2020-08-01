<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin is used to access macamvimeo items
 * Macamvimeo Repository Plugin
 *
 * @since 2.0
 * @package    repository_macamvimeo
 * @copyright  2017 Mofet
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


global $CFG;
require_once($CFG->dirroot . '/repository/lib.php');

class repository_macamvimeo extends repository {
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array()) {
        parent::__construct($repositoryid, $context, $options);

    }

    public function check_login() {
        return false;
    }

    public function print_login() {

        global $CFG;
        global $COURSE;

        //Init our array
        $ret = array();

        $search = new stdClass();
        $search->type = 'hidden';
        $search->id   = 'search';
        $search->name = 's';

        $search->label = "<iframe scrolling=\"no\" frameBorder=\"0\" src=\"{$CFG->wwwroot}/repository/macamvimeo/repo/dialog.php?repo_id={$this->id}&course={$COURSE->idnumber}\" height=\"1700\" width=\"560\"></iframe>";

        $sort = new stdClass();
        $sort->type = 'hidden';
        $sort->options = array();
        $sort->id = 'mm_sort';
        $sort->name = 'mm_sort';
        $sort->label = '';

        $ret['login'] = array($search, $sort);
        $ret['login_btn_label'] = 'Next >>>';
        $ret['login_btn_action'] = 'search';

        return $ret;
    }

    public function get_listing($path='', $page = '') {
        $list =array();
        return $list;
    }



    public function logout() {
        return parent::logout();
    }

    /**
     * Return file URL, for most plugins, the parameter is the original
     * url, but some plugins use a file id, so we need this function to
     * convert file id to original url.
     *
     * @param string $url the url of file
     * @return string
     */
    public function get_link($url) {
        return "vimeo://"."{$url}";
    }

    public function supported_filetypes() {
        return array('video');
    }
    public function supported_returntypes() {
        return FILE_EXTERNAL;
    }

    public static function get_type_option_names() {
        return array('client_id', 'client_pass','token', 'pluginname');
    }

    public static function type_config_form($mform, $classname = 'repository') {
        parent::type_config_form($mform, $classname);
        $mform->addElement('text', 'client_id', get_string('client_id', 'repository_macamvimeo'));
        $mform->addElement('text', 'client_pass', get_string('client_pass', 'repository_macamvimeo'));
        $mform->addElement('text', 'token', get_string('token', 'repository_macamvimeo'));
    }
}
