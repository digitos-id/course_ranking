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
    $params['courseid'] = 3;
    $data = array_values($DB->get_records_sql($sql, $params));
    // var_dump($data); exit();

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

    // Add a setting field to the settings for this page
    // $settings->add(new admin_setting_configtext(
        // This is the reference you will use to your configuration
        // 'local_course_ranking/apikey',

        // This is the friendly title for the config, which will be displayed
        // 'External API: Key',

        // This is helper text for this config field
        // 'This is the key used to access the External API',

        // This is the default value
        // 'No Key Defined',

        // This is the type of Parameter this config is
        // PARAM_TEXT
    // ));
}