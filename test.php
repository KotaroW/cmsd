<?php
define('ALEXANDER_THE_GREAT', 'heisthegreatest');


include_once('includes/class-web-page.php');
$webpage = new Web_Page('index', 'template');

$max = rand(1, 10);
$rows = [];

for($index = 0; $index < $max; $index++) {
    $rows[] = '<tr><td>' . ($index + 1) . '</td></tr>';
}


$contents =<<<KOTAROW
    <h1>This is a test</h1>
    <div>
        <p>This is a test.</p>
        <table border="1">
            %s
        </table>
    </div>
KOTAROW;

$contents = sprintf(
    $contents,
    implode("\n\t\t\t", $rows) . PHP_EOL
);

$webpage->build_contents(
    function ($config) use ($webpage, $contents) {
        $webpage->page_contents = $contents;
    }
);
$webpage->build_header();
$webpage->display();
?>