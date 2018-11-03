<!DOCTYPE html>
<html>
<head>
    <title>Example: WANMonitor-Graph</title>
    <!-- This example uses chartist from CDN to draw two charts (up/downstream). -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
</head>
<body>
<div>
    <h3>Downstream</h3>
    <div class="ct-chart" id="down-chart"></div>
</div>
<div>
    <h3>Upstream</h3>
    <div class="ct-chart" id="up-chart"></div>
</div>

<?php
// the following code could be an ajax-endpoint to be called every five seconds

use Holger\Holger;

require_once '../vendor/autoload.php';

$credentials = [
    'username' => 'user',
    'password' => 'password',
];

if (file_exists('../config.php')) {
    $loadedCredentials = include '../config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$holger = new Holger('192.168.178.1', $credentials['password'], $credentials['username']);

try {
    $stats = $holger->monitor->getOnlineMonitor();

    $option_down_chart = $option_up_chart = [
        'height' => 200,
    ];
    $data_down_chart = $data_up_chart = [
        'labels' => [
            '-100',
            '-95',
            '-90',
            '-85',
            '-80',
            '-75',
            '-70',
            '-65',
            '-60',
            '-55',
            '-50',
            '-45',
            '-40',
            '-35',
            '-30',
            '-25',
            '-20',
            '-15',
            '-10',
            '-5',
        ],
        'series' => [],
    ];

    array_push($data_down_chart['series'], array_reverse(explode(',', $stats['Newds_current_bps'])));
    array_push($data_up_chart['series'], array_reverse(explode(',', $stats['Newus_current_bps'])));

    if (true === array_key_exists('Newmax_ds', $stats)) {
        $option_down_chart['high'] = $stats['Newmax_ds'];
    }
    if (true === array_key_exists('Newmax_us', $stats)) {
        $option_up_chart['high'] = $stats['Newmax_us'];
    }
    ?>
    <script>
        new Chartist.Line(
            '#down-chart',
            <?php echo json_encode($data_down_chart); ?>,
            <?php echo json_encode($option_down_chart); ?>
        );
        new Chartist.Line(
            '#up-chart',
            <?php echo json_encode($data_up_chart); ?>,
            <?php echo json_encode($option_up_chart); ?>
        );
    </script>
    <?php
} catch (Exception $e) {
    dump($e);
}

?>
</body>
</html>
