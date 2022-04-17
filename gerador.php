<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: "dados.php",
          dataType: "json",
          async: false
          }).responseText;
          

          var data = new google.visualization.DataTable(jsonData);


var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data, {width: 400, height: 240});
    }

    </script>
</head>

<?php
     $valores = isset($_POST["valores"]) ? ($_POST["valores"]) : 0;
     $inicio = isset($_POST["inicio"]) ? ($_POST["inicio"]) : 0;
     $fim = isset($_POST["fim"]) ? ($_POST["fim"]) : 0;

     $numeros = array();
     $par = array();
     $impar = array();
    $soma = 0;
    $média = 0; 
    $acimas = array();
    $abaixos = array();
    $primos = array();
    $x = 0;
    $i = $valores;
    

    if ($inicio && $fim && $valores) {
        mt_srand();
        for ($i = 0 ; $i < $valores; $i++) {
            $numeros[] = mt_rand($inicio, $fim);
            echo $numeros[$i]."<br/>"; 
        }

        echo "Maior : " . max($numeros)."<br/>"; 
        echo "Menor : " . min($numeros)."<br/>"; 
    
    $pares = [];
    $impares = [];
    $abaixo = [];
    $acima = [];
    $primo  = [];
    $divisores = 0;

    foreach ($numeros as $num) {
        if ($num % 2 == 0) {
            $pares[] = $num;
        } else {
            $impares[] = $num;
        }
    }
  
     echo "Pares é " ;
     foreach ($pares as $par) {
         echo ", ".$par;
     }

     echo "</br> Impares é " ;
     foreach ($impares as $impar) {
         echo ", ".$impar;
     }

     for ( $i = 0 ; $i < $valores; $i++){
        $soma = $numeros[$i] + $soma;
    }
    echo "</br>Soma : ". $soma;
    echo "</br>Média : " . ($soma/$valores);

    for ($i = 0 ; $i < $valores; $i++) {
        if ($numeros[$i] >= ($soma/$valores)){
            $acima[] = $numeros[$i];
        } else {
            $abaixo[] = $numeros[$i];
        }
    }
    echo "</br> Acima da Média é " ;
    foreach ($acima as $acimas) {
        echo ", ".$acimas;
    }

    echo "</br> Abaixo da Média é " ;
    foreach ($abaixo as $abaixos) {
        echo ", ".$abaixos;
    }


    for ($i = 2 ; $i < $valores; $i++) {

            if (fmod($numeros[$i],$i) != 0) {       
                $primo[$i] = $numeros[$i];
            }
        }
    
    echo "</br> Primos é " ;
    foreach ($primo as $primos) {
        echo ", ".$primos;
    }


    $dados = array($valores,$inicio,$fim,$numeros,min($numeros), max($numeros), $pares,$impares,$soma,($soma/$valores),$acima,$abaixo,$primos);
    $dados_json = json_encode($dados);
    $fp = fopen("dados.json", "w");
fwrite($fp, $dados_json);
fclose($fp);

$arquivo = file_get_contents('dados.json');
$json = json_decode($arquivo);
}


?>
<body>
<form method= "POST"> 
    <label for="valores"> Valores </label> 
<input type="number" name="valores" value=<?php echo $valores?>> 
<br>
<label for="inicio"> Início </label>
<input type="number" name="inicio" value=<?php echo $inicio?>>
<br>
<label for="fim"> Fim </label>
<input type="number" name="fim" value=<?php echo $fim?>>
<br>
<input type="submit"> 
 
<div id="chart_div"></div>

  
 

    
</form>
</body>
</html>