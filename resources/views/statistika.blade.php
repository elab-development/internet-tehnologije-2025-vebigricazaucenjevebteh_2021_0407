<!DOCTYPE html>
<html>
<head>
    <title>Statistika bodova</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>

<h2>Ukupan broj bodova po korisniku</h2>

<div id="chart_div" style="width: 900px; height: 500px;"></div>

<script>
google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    fetch('/api/statistika/bodovi')
        .then(response => response.json())
        .then(data => {

            let chartData = [['Korisnik', 'Ukupno bodova']];

            data.forEach(item => {
                chartData.push([item.ime, parseInt(item.ukupno_bodova)]);
            });

            let dataTable = google.visualization.arrayToDataTable(chartData);

            let options = {
                title: 'Ukupan broj bodova po korisniku',
                legend: { position: 'none' },
                colors: ['#4CAF50']
            };

            let chart = new google.visualization.ColumnChart(
                document.getElementById('chart_div')
            );

            chart.draw(dataTable, options);
        });
}
</script>

</body>
</html>
