<?php if (!defined('SPLASH-VD')) exit(); ?>
<?php
include dirname(__FILE__).'/_header.tpl';
?>

<script>
	  var chartDatas = <?php echo $json; ?>;
	  var chartDatasSessions = <?php echo $jsonSessions; ?>;
	
	  var chart = null;
	  var chartSession = null;
        var data = null;
		var dataSessions = null;
		var options = null;
		var optionsSessions = null;
		var index = '<?php echo $index; ?>';

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Upload');
        data.addColumn('number', 'Download');
        data.addRows(chartDatas);
        dataSessions = new google.visualization.DataTable();
        dataSessions.addColumn('string', 'Date');
        dataSessions.addColumn('number', 'Sessions');
        dataSessions.addRows(chartDatasSessions);

        // Set chart options
        options = {'title':'Données',
					   series: {
							0: {targetAxisIndex: 0},
							1: {targetAxisIndex: 0}
							},
							vAxes: {
							0: {title: 'Données', format: '# '+index}
							}
					};
        optionsSessions = {'title':'Sessions',
					   series: {
							0: {targetAxisIndex: 0}
							},
							vAxes: {
							0: {title: 'Sessions'}
							}
					};

		chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chartSession = new google.visualization.LineChart(document.getElementById('chart_session_div'));
        // Instantiate and draw our chart, passing in some options.
		chart.draw(data, options);
		chartSession.draw(dataSessions, optionsSessions);
	  }
	  
	  function resizeChart () {
		  if (chart) chart.draw(data, options);
		  if (chartSession) chartSession.draw(dataSessions, optionsSessions);
		}
		if (document.addEventListener) {
			window.addEventListener('resize', resizeChart);
		}
		else if (document.attachEvent) {
			window.attachEvent('onresize', resizeChart);
		}
		else {
			window.resize = resizeChart;
		}


</script>
<main>
	<div class="divContent">
		<div class="instant">
			Nombre de session<?php echo ($instant<=1)?'':'s'; ?> active<?php echo ($instant<=1)?'':'s';?> : <?php echo $instant; ?><br />
		</div>
		
		<div class="frm">
		<form method="get" action="index.php">
			Date de début : <input type="date" name="fromDte" value="<?php echo $fromDte; ?>" />
			Date de fin : <input type="date" name="toDte" value="<?php echo $toDte; ?>" />
			<input type="submit" value="Rechercher" />
		</form>
		</div>
		<div id="chart_div"></div>
		<div id="chart_session_div"></div>
	</div>
	

</main>
<?php
include dirname(__FILE__).'/_footer.tpl';
?>