<?php

include('session.php');

include('conexao.php');

// INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade )
// VALUES (
// 'Teste 4',
// '1',
// NULL,
// 'A',
// '1',
// '1',
// '1'
// )

if($_FILES['imagem']['size'] > 0){
	$fileName = $_FILES['imagem']['name'];
	$tmpName  = $_FILES['imagem']['tmp_name'];
	$fileSize = $_FILES['imagem']['size'];
	$fileType = $_FILES['imagem']['type'];

	

	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	fclose($fp);

	$queryImg = 
			"INSERT INTO 
				imagem (tituloImagem, bitmapImagem)
			VALUES (? , ?)";

	$paramsImg = array ($fileName, $content);

	$prepImg = odbc_prepare($connect, $queryImg );
	$resultImg = odbc_execute($prepImg, $paramsImg );

	$queryQuestao = 
		"INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade )
		VALUES (?,?, IDENT_CURRENT( 'IMAGEM' ), ?, ?, ?, ?)";
		
	$paramsQuestao = array ($_POST['txQuestao'], $_POST['codAssunto'], $_POST['codTipoQuestao'], $_SESSION['codProfessor'], $_POST['ativo'], $_POST['dificuldade']);

	$prepQuestao = odbc_prepare($connect, $queryQuestao);
	$resultQuestao = odbc_execute($prepQuestao, $paramsQuestao);


	/*echo "<br>File $fileName uploaded<br>";
	return $fileName;*/
} 

?>