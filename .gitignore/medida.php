<?php

	$servidor='localhost';
	$banco='measurer';
	$usuario='root';
	$senha='';
	$link = mysqli_connect($servidor,$usuario,$senha, $banco);
	date_default_timezone_set('America/Sao_Paulo');
	$horario = date('Y-m-d H:i:s', time());
	
	if (isset($_GET['vazao'])) {
		
		$vazao = $_GET['vazao'];

		$query = "INSERT INTO medidas(horario, vazao) VALUES ('$horario','$vazao')";
	
		mysqli_query($link,$query);
		mysqli_close($link);

		echo 'DADOS INSERIDOS NO BANCO!';

	}else{


		echo 'ERRO AO GRAVAR NO BANCO DE DADOS!';
	}	
?>
