<?php

	$servidor='localhost';
	$banco='measurer';
	$usuario='root';
	$senha='';
	$link = mysqli_connect($servidor,$usuario,$senha, $banco);

	$horario = date('Y-m-d H:i:s');
	
	if (isset($_GET['vazao'])) {
		
		$vazao = $_GET['vazao'];

		$query = "INSERT INTO medidas(horario, vazao) VALUES ('$horario','$vazao')";
	
		mysqli_query($link,$query);
		mysqli_close($link);

		echo 'DADOS INSERIDOS NO BANCO!';

	}else{


		echo 'ERRO AO GRVAR NO BANCO DE DADOS!';

	}

	
	
?>
