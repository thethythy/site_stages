<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"/>
<script type="text/javascript" src="jsscripts/highcharts.js"/>
<script type="text/javascript" src="jsscripts/themes/gray.js"/>
<script type="text/javascript" src="jsscripts/wz_jsgraphics.js"/>
<script type="text/javascript" src="jsscripts/pie.js"/>

<script type="text/javascript">
	var chart1; // globally available
	$(document).ready(function() { });
</script>

<script type="text/javascript" src="scripts/jschart.js"/>

<script type="text/javascript">

function sort(el) {
	var col_sort = el.innerHTML;
	var tr = el.parentNode;
	var table = tr.parentNode;
	var td, arrow, col_sort_num;

	for (var i = 0; (td = tr.getElementsByTagName("td").item(i)); i++) {
		if (td.innerHTML == col_sort) {
			col_sort_num = i;
			if (td.prevsort == "y") {
				arrow = td.firstChild;
				el.up = Number(!el.up);
			} else {
				td.prevsort = "y";
				arrow = td.insertBefore(document.createElement("span"),td.firstChild);
				el.up = 0;
			}
			arrow.innerHTML = el.up?"&#8593; ":"&#8595; ";
		} else {
			if (td.prevsort == "y") {
				td.prevsort = "n";
				if (td.firstChild) td.removeChild(td.firstChild);
			}
		}
	}

	var a = new Array();
	for (i = 1; i < table.rows.length; i++) {
		a[i-1] = new Array();
		a[i-1][0]=table.rows[i].getElementsByTagName("td").item(col_sort_num).innerHTML;
		a[i-1][1]=table.rows[i];
	}
	a.sort();
	if (el.up) a.reverse();
	for (i = 0; i < a.length; i++) table.appendChild(a[i][1]);
}

function showAdresse(adresse, ville, pays) {
	//alert(adresse);
	//alert(ville);
	//alert(pays);
	var newWindow = window.open("afficheMap.html","newWindow","width=500,height=400, menubar=yes, location=yes, status=yes, toolbar=no, resizeable=yes, scrollbars=no");	
	newWindow.document.open(); 
	newWindow.moveTo((screen.availWidth-500)/2,(screen.availHeight-400)/2);
}

function setVillesChart(donnees) {
	var options = {
		chart: {
			renderTo: 'ville-container',
			defaultSeriesType: 'column'
		},
		title: {
			text: 'Répartition par ville'
		},
		xAxis: {
			categories: ['Villes']
		},
		yAxis: {
			title: {
				text: 'Nombre de stages'
			}
		},
		series: []
	};

	// coding graph (villes)
	var arr = donnees.split(';');
	var count = arr.length;
	var i;
	for (i = 0; i < count; i += 2) {
		var series = {
			data: []
		};

		series.name = arr[i];
		series.data.push(parseInt(arr[i+1]));
		options.series.push(series);
	}

	chart1 = new Highcharts.Chart(options);
}

function setPaysChart(donnees) {
	var options = {
		chart: {
			renderTo: 'pays-container',
			defaultSeriesType: 'column'
		},
		title: {
			text: 'Répartition par pays'
		},
		xAxis: {
			categories: ['Pays']
		},
		yAxis: {
			title: {
				text: 'Nombre de stage'
			}
		},
		series: []
	};

	// coding graph (pays)
	var arr = donnees.split(';');
	var count = arr.length;
	var i;
	for (i = 0; i < count; i +=2 ) {
		var series = {
			data: []
		};

		series.name = arr[i];
		series.data.push(parseInt(arr[i+1]));
		options.series.push(series);
	}

	chart2 = new Highcharts.Chart(options);
}

</script>
