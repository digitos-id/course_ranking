<?php

defined('MOODLE_INTERNAL') || die();

define ('DEFAULT_POINTS', 2);

function generate_table_ranking($data, $course) {
    global $USER;

    if (empty($data)) {
        return "No students to show";
    }

    $table = new html_table();
    $table->attributes['class'] = 'rankingTable table table-striped generaltable';
    $table->head = array("POS", "Name", "Grade");

    for ($i = 0; $i < count($data); $i++) {
        $row = new html_table_row();

        // Verify if the logged user is one user in ranking.
        if ($data[$i]->id == $USER->id) {
            $row->attributes = array('class' => 'itsme');
        }

        $row->cells = array(
            $i+1,
            $data[$i]->firstname,
            $data[$i]->grade
        );

        $table->data[] = $row;
    }

    // return '<div><h4>Ranking ' . $course->fullname . '</h4></div>' . html_writer::table($table);
    return '<div class="local_courseranking">' . html_writer::table($table) . '</div>';
    // return "ok";

}