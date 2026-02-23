import { useEffect } from "react";

export default function Statistika() {

  useEffect(() => {

    const script = document.createElement("script");
    script.src = "https://www.gstatic.com/charts/loader.js";
    script.onload = () => {
      window.google.charts.load('current', { packages: ['corechart'] });
      window.google.charts.setOnLoadCallback(drawChart);
    };
    document.body.appendChild(script);

    function drawChart() {
      fetch("https://internet-tehnologije-2025-46xs.onrender.com/api/statistika/bodovi")
        .then(res => res.json())
        .then(data => {

          const chartData = [['Korisnik', 'Ukupno bodova']];

          data.forEach(item => {
            chartData.push([item.ime, parseInt(item.ukupno_bodova)]);
          });

          const dataTable = window.google.visualization.arrayToDataTable(chartData);

          const options = {
            title: 'Ukupan broj bodova po korisniku',
            legend: { position: 'none' }
          };

          const chart = new window.google.visualization.ColumnChart(
            document.getElementById('chart_div')
          );

          chart.draw(dataTable, options);
        });
    }

  }, []);

  return (
    <div style={{ padding: 20 }}>
      <h2>Statistika</h2>
      <div id="chart_div" style={{ width: "900px", height: "500px" }}></div>
    </div>
  );
}
