<html>
	<head>
<script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="../assets/js/highcharts.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function () {
    var chart;     
    $(document).ready(function () {
        // Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container1',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Penjualan smartphone bulan september 2012'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
//data prosentasi penjualan di letakan disini!
            series: [{
                type: 'pie',
                name: 'Presentase penjualan',
                data: [
                    ['Android',   45.0],
                    ['Blackberry',35.0],
                     
                    ['iPhone',    15.0],
                    ['Windowphone',     5.0]
                ]
            }]
        });
    });
     
});
</script>
	</head>
	<body>
		<div id='container1'></div>		
	</body>
</html>