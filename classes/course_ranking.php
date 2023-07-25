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
        $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

        $rangkingzize = get_config('local_course_ranking', 'rankingsize');

        $sql = "SELECT u.id, u.firstname , u.lastname , u.email 
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
            LIMIT " . $rangkingzize;

        $params['courseid'] = $courseid;
        $data = array_values($DB->get_records_sql($sql, $params));
        
        return generate_table_ranking($data, $course);
    }

    public  static function coursename()
    {
        global $DB;
        $courseid = get_config('local_course_ranking', 'courserangking');
        $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

        return $course->fullname;
    }
}