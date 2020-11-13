<?php
//Se incluye el archivo Conexion.php que contiene la clase usada para la conexion a la bd
include ("conexion/Conexion.php");
//Se crea el objeto conexion
$bd = new Conexion();
//Se inicia la sesion o se propaga
session_start();
//Condicion que no deja entrar al index a menos que exista una variable de session
if(!isset($_SESSION["id_usuario"])){
//Redirecciona al login
header("Location: login.php");
}

//Contar las autos nuevos, usados y chocados que han sido subastados
$cont_nuevos = $bd->select("SELECT count(*) as nuevo from auto where estado='Nuevo'");
$data=mysqli_fetch_array($cont_nuevos);
$contNuevo = $data['nuevo']; //Total de autos nuevos

$cont_usados = $bd->select("SELECT count(*) as usado from auto where estado='Usado'");
$data=mysqli_fetch_array($cont_usados);
$contUsado = $data['usado']; //Total de autos usados

$cont_chocados = $bd->select("SELECT count(*) as chocado from auto where estado='Chocado'");
$data=mysqli_fetch_array($cont_chocados);
$contChocado = $data['chocado']; //Total de autos chocados


//Contar las autos nuevos, usados y chocados que han sido comprados por cada usuario.
$contarNuevo = $bd->select("SELECT count(a.estado) as total from auto a 
                            INNER JOIN subasta s ON a.id_auto = s.id_auto 
                            INNER JOIN cesta c ON s.id_subasta = c.id_subasta
                            INNER JOIN usuario u ON c.id_usuario = u.id_usuario WHERE u.id_usuario='".$_SESSION['id_usuario']."' AND a.estado='Nuevo'");
$data2=mysqli_fetch_array($contarNuevo);

$totalNUevo = $data2['total'];



?>

<div id="graficabarras"></div>

<script type="text/javascript">

	var yValue = [<?php echo $contNuevo; ?>,<?php echo $contUsado; ?>,<?php echo $contChocado; ?>];
	var data = [
	{
		x: ['Nuevos', 'Usados','Chocados'],
		y: yValue,
		
		type: 'bar',
		text: yValue.map(String),
		hoverinfo: 'none',
		textposition: 'auto',
		marker: {
      		color: ['rgb(155, 226, 128)','rgb(235, 219, 55)','rgb(227, 116, 91)']
    	}
	}
	];

	var layout = {
		title: '',
		xaxis:{
			title: 'Estado del automóvil',
			tickangle: -45
		},
		yaxis:{
			title: 'Cantidad de automóviles',
		}

	};	

	Plotly.newPlot('graficabarras', data, layout);


	
</script>