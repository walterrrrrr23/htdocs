<?php


ini_set('display_errors', 'on');

function connectionDB()
{
	$res = mysqli_connect(SERVEUR, USER, PWD, DB_NAME);
	if(mysqli_connect_errno()){
		echo "Echec de Connexion :".mysqli_connect_errno();
	}
	mysqli_set_charset($res, "utf8");
	return $res;


}

function closeDB($mysqli)
{
	mysqli_close($mysqli);
}


function readDB($mysqli, $sql_input)
{
	$query_output = mysqli_query($mysqli, $sql_input);
	if(!$query_output || mysqli_num_rows($query_output) == 0){
		return array();
	}
	return $query_output->fetch_all(MYSQLI_ASSOC);

}

function writeDB($mysqli, $sql_input)
{
	$query_output = mysqli_query($mysqli, $sql_input);
	return $query_output;
}

?>