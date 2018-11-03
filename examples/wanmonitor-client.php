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
<script>
    const times = ['-100', '-95', '-90', '-85', '-80', '-75', '-70', '-65', '-60', '-55', '-50', '-45', '-40', '-35', '-30', '-25', '-20', '-15', '-10', '-5'];

    const downchart = new Chartist.Line(
        '#down-chart',
        {},
        {}
    );
    const upchart = new Chartist.Line(
        '#up-chart', {}, {}
    );

    function refreshCharts() {
        fetch('wanmonitor-server.php').then((response) => response.json()).then((json) => {
            downchart.update({
                    labels: times,
                    series: [json.downstream.total.reverse(), json.downstream.iptv],
                },
                {
                    high: json.max.down,
                    height: 200,
                });

            upchart.update(
                {
                    labels: times,
                    series: [json.upstream.total.reverse(), json.upstream.realtime.reverse(), json.upstream['high-priority'].reverse(), json.upstream.default.reverse(), json.upstream['background-tasks'].reverse()],
                },
                {
                    high: json.max.up,
                    height: 200,
                }
            );
        });
    }

    window.setInterval(refreshCharts, 5000);
</script>
</body>
</html>
