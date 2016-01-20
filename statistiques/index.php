<!DOCTYPE html>
<html>
	<head>
		<title>Statistiques Reloaded</title>
		<script src="jquery.js"></script>
		<script src="Chart.js"></script>
	</head>
	<body>
		<canvas id="mycanvas" width="512" height="512">
		</canvas>
		<script>
			$(document).ready(function(){
				var ctx = $("#mycanvas").get(0).getContext("2d");
				//pie chart data
				//sum of values = peu importe
				var data = [
					{
						value: 800,
						color: "cornflowerblue",
						highlight: "lightskyblue",
						label: "youhou"
					},
					{
						value: 120,
						color: "lightgreen",
						highlight: "yellowgreen",
						label: "blabla"
					},
					{
						value: 40,
						color: "orange",
						highlight: "darkorange",
						label: "akada miam miam"
					},
					{
						value: 40,
						color: "red",
						highlight: "darkred",
						label: "essai"
					}
				];
				//draw
				var piechart = new Chart(ctx).Pie(data);
				//var linechart = new Chart(ctx).Line(data);
			});
		</script>

		<canvas id="mycanvas2" width="512" height="512">
		</canvas>
		<script>
			$(document).ready(function(){
				var ctx = $("#mycanvas2").get(0).getContext("2d");
				//pie chart data
				//sum of values = peu importe
				var data = {
				    labels: ["January", "February", "March", "April", "May", "June", "July"],
				    datasets: [
				        {
				            label: "My First dataset",
				            fillColor: "rgba(220,220,220,0.2)",
				            strokeColor: "rgba(220,220,220,1)",
				            pointColor: "rgba(220,220,220,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(220,220,220,1)",
				            data: [65, 59, 80, 81, 560, 55, 40]
				        },
				        {
				            label: "My Second dataset",
				            fillColor: "rgba(151,187,205,0.2)",
				            strokeColor: "rgba(151,187,205,1)",
				            pointColor: "rgba(151,187,205,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(151,187,205,1)",
				            data: [28, 48, 40, 19, 86, 27, 90]
				        },
				        {
				            label: "My Third dataset",
				            fillColor: "rgba(0,187,100,0.2)",
				            strokeColor: "rgba(0,187,100,1)",
				            pointColor: "rgba(0,187,100,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(0,187,100,1)",
				            data: [84, 26, 75, 14, 02, 23, 71]
				        }
				    ]
				};

				//draw
				var linechart = new Chart(ctx).Line(data);
			});
		</script>
	</body>
</html>