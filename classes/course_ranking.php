<?php

namespace local_course_ranking;
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/local/course_ranking/lib.php');

class course_ranking {

    public static function useremail2() {
        global $USER;
        return $USER->email . " ok";
    }

    public static function courseranking() {
        global $DB;
        $courseid = get_config('local_course_ranking', 'courserangking');

        $sql = "SELECT u.firstname , u.lastname , u.email 
            , cc.name CourseName,
            ROUND(gg.finalgrade,2) Grade,
            FROM_UNIXTIME(gi.timemodified) TimeModified
            FROM {course} c
            JOIN {context} ctx ON c.id = ctx.instanceid
            JOIN {role_assignments} ra ON ra.contextid = ctx.id
            JOIN {user} u ON u.id = ra.userid
            JOIN {grade_grades} gg ON gg.userid = u.id
            JOIN {grade_items} gi ON gi.id = gg.itemid
            JOIN {course_categories} cc ON cc.id = c.category
            WHERE gi.courseid = c.id AND gi.itemtype = 'course'
            AND c.id = :courseid
            order by Grade desc
        ";
        $params['courseid'] = $courseid;
        $data = array_values($DB->get_records_sql($sql, $params));
        // var_dump($data); exit();
        
        $html = '<div id="mensal" class="yui3-tab-panel yui3-tab-panel-selected" role="tabpanel" aria-labelledby="yui_3_17_2_1_1687770757383_69"><div class="table-responsive" id="yui_3_17_2_1_1687770757383_734"><table class="rankingTable table table-striped generaltable" id="yui_3_17_2_1_1687770757383_733">
        <thead id="yui_3_17_2_1_1687770757383_732">
        <tr id="yui_3_17_2_1_1687770757383_731">
        <th class="header c0" style="" scope="col" id="yui_3_17_2_1_1687770757383_730">Pos</th>
        <th class="header c1" style="" scope="col">Fullname</th>
        <th class="header c2 lastcol" style="" scope="col">Points</th>
        </tr>
        </thead>
        <tbody><tr class="">
        <td class="cell c0" style="">1</td>
        <td class="cell c1" style=""><a href="http://localhost:8000/user/view.php?id=38&amp;course=3" class="d-inline-block aabtn"><span class="userinitials size-24">HB</span></a> Hanna</td>
        <td class="cell c2 lastcol" style="">19.0</td>
        </tr>
        <tr class="">
        <td class="cell c0" style="">2</td>
        <td class="cell c1" style=""><a href="http://localhost:8000/user/view.php?id=20&amp;course=3" class="d-inline-block aabtn"><span class="userinitials size-24">EB</span></a> Ethan</td>
        <td class="cell c2 lastcol" style="">16.0</td>
        </tr>
        <tr class="lastrow">
        <td class="cell c0" style="">3</td>
        <td class="cell c1" style=""><a href="http://localhost:8000/user/view.php?id=44&amp;course=3" class="d-inline-block aabtn"><span class="userinitials size-24">LB</span></a> Laura</td>
        <td class="cell c2 lastcol" style="">6.0</td>
        </tr>
        </tbody>
        </table>
        </div>
    </div>';

        
        return generate_table_ranking($data);
        // return "OK";
    }
}