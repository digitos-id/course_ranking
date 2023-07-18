<?php

// Ensure the configurations for this site are set
if ($hassiteconfig) {
    global $DB;

    // Create the new settings page
    // - in a local plugin this is not defined as standard, so normal $settings->methods will throw an error as
    // $settings will be null
    $settings = new admin_settingpage('local_course_ranking', 'Course Ranking');

    // Create
    $ADMIN->add('localplugins', $settings);

    // require_once($CFG->libdir . '/gradelib.php');
    // require_once($CFG->dirroot . '/grade/querylib.php');
    // $gradeobj = grade_get_course_grades(3, [44, 38, 20]);
    // $fields = \core_user\fields::for_userpic()->get_required_fields();

    $courses = get_courses();
    $course_list = array();
    foreach ($courses as $data) {
        if ($data->category != "0") {
            // array_push($course_list, (object)[$data->id => $data->fullname]);
            $course_list[$data->id] = $data->fullname;
        }
    }
    // var_dump($course_list);
    $name = 'local_course_ranking/courserangking';
    $title = get_string('courserangking', 'local_course_ranking');
    $description = get_string('courserangkingdesc', 'local_course_ranking');
    $default = 1;
    $choices = $course_list;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

}