<html>
	</body>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Medidor de Consumo de Energia e Água</title>
		<link rel="stylesheet" href="estilo.css">
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		  google.load("visualization", "1.0", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
		    var data = new google.visualization.DataTable();
		    data.addColumn('string', 'Horário');
		    data.addColumn('number', 'Vazão')
		    data.addRows([

				<?php
					$servidor='localhost';
  					$banco='measurer';
   					$usuario='root';
   					$senha='';
					$link = mysqli_connect($servidor,$usuario,$senha, $banco);
					$yday = date('Y-m-d h:i:s', strtotime("-1 day"));
					$query = "SELECT * FROM medidas WHERE horario > '$yday'";
					$result = mysqli_query($link,$query);
					$row = mysqli_fetch_array($result);
					if ($row) {
						$continue = true;
					} else {
						$continue = false;
					}
					while ($continue) {	
					    $horario=$row['horario'];
					    $vazao=$row['vazao'];
					    echo("['$horario', $vazao]");
						$row = mysqli_fetch_array($result);
					if ($row) {
						$continue = true;
						echo(",\n");
					} else {
						$continue = false;
						echo("\n");
					}
					}
				?>	    	
		    ]);
		    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
		    chart.draw(data, {width: 1000, height: 400, title: 'Medidor de Consumo de Energia e Água', hAxis: {title: 'Horário',titleTextStyle: {color: '#FF0000'}}
		    });
	 	} </script>
	</head>

	<body>
		<h1>Medidor de Consumo de Energia e Água</h1>
		<h2>Consumo das Últimas 24 horas</h2>

		<?php
			ini_set('display_errors', 'On');
			$link = mysqli_connect($servidor,$usuario,$senha, $banco);
			$yday = date('Y-m-d h:i:s', strtotime ("-1 day"));
			$query = "SELECT * FROM medidas WHERE horario > '$yday'";
			$result = mysqli_query($link,$query);	
			$consumo_vazao = 0.0;
			$horario_anterior = '';
			$vazao_anterior = 0;
			$horario_atual = '';
			$vazao_atual = 0;
			$var_horario = '';

			while ($row = mysqli_fetch_array($result)) {	
			    $horario_atual=$row['horario'];
			    $vazao_atual=$row['vazao'];
			    echo("$horario_atual ==> ");
			    echo(strtotime($horario_atual));
			if ($horario_anterior <> '') {
		    	$var_horario = strtotime($horario_atual) - strtotime($horario_anterior);
		    	$consumo_atual2 = $var_horario * ($vazao_atual + $vazao_anterior) / 2;
		    	$consumo_vazao = $consumo_vazao + $consumo_atual2;
		    	echo(".");
		    }
		    	$horario_anterior=$horario_atual;
		    	$vazao_anterior=$vazao_atual;
				echo("$var_horario <br>\n");
			}
		?>
		O consumo total de água foi:
		<strong><?php echo($consumo_vazao); ?> Litros </strong> ou 
		<strong><?php echo($consumo_vazao); ?> L/min </strong>. <br>

		<div id="chart_div"></div>
		
		<h2>Últimas Medidas</h2>

		<?php
			$link = mysqli_connect($servidor,$usuario,$senha,$banco);
			$query="SELECT count(*) as total FROM medidas";
			$result=mysqli_query($link,$query);
			$data=mysqli_fetch_assoc($result);
			$total_de_medidas = $data['total'];
			$query="SELECT * FROM medidas  ORDER BY horario DESC LIMIT 20";
			$result=mysqli_query($link,$query);
			$num=mysqli_num_rows($result);
			mysqli_close($link);
		?>


		Mostrando as 20 últimas medidas de um total de 
		<strong><?php echo($total_de_medidas) ?> medidas
		</strong>. <br><br>

		<table border="1" cellspacing="2" cellpadding="2">
			<tr>
			<td><strong>Horário</strong></td>
			<td><strong>Vazão (L/min)</strong></td>
			</tr>

			<?php
			$i=0;
				while ($row = mysqli_fetch_assoc($result)) {
				$horario=$row['horario'];
				$vazao=$row['vazao'];
			?>

			<tr>
			<td align="right"><?php echo $horario; ?></td>
			<td align="right"><?php echo $vazao; ?></td>
			</tr>

			<?php
				$i++;
				}
			?>
		</table>
	</body>
</html>
