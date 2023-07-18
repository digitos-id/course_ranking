Plugin ini membutuhkan plugin filter shortcode, setelah ditambahkan plugin filter shortcode, pada file filter/shortcodes/db/shortcodes.php tambahkan code berikut :  
```php
<?php
defined('MOODLE_INTERNAL') || die();

$shortcodes = [
    'courseranking' => [
        'callback' => 'local_course_ranking\course_ranking::courseranking'
    ]
];
```