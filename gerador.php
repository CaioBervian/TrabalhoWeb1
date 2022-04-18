<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
    </script>
</head>

<?php
    $valores = (int) (isset($_POST["valores"]) ? ($_POST["valores"]) : 0);
    $inicio = (int) (isset($_POST["inicio"]) ? ($_POST["inicio"]) : 0);
    $fim = (int) (isset($_POST["fim"]) ? ($_POST["fim"]) : 0);

    $numeros = array();
    $par = array();
    $impar = array();
    $soma = 0;
    $media = 0;
    $acimas = array();
    $abaixos = array();
    $primos = array();
    $pares = [];
    $impares = [];
    $divisores = 0;
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

        $soma = array_sum($numeros);
        $media = ($soma/count($numeros));
        echo "</br>Soma : ". $soma;
        echo "</br>Média : " . $media;

        for ($i = 0 ; $i < count($numeros); $i++) {
            if ($numeros[$i] >= $media) {
                $acimas[] = $numeros[$i];
            } else {
                $abaixos[] = $numeros[$i];
            }
        }
        echo "</br> Acima da Média é " ;
        foreach ($acimas as $acima) {
            echo ", ".$acima;
        }

        echo "</br> Abaixo da Média é " ;
        foreach ($abaixos as $abaixo) {
            echo ", ".$abaixo;
        }
        function isPrime($n)
        {
            if ($n <= 1) {
                return false;
            }
            for ($i = 2; $i < $n; $i++) {
                if ($n % $i == 0) {
                    return false;
                }
            }
            return true;
        }

        for ($i = 0 ; $i < count($numeros); $i++) {
            if (isPrime($numeros[$i])) {
                $primos[] = $numeros[$i];
            }
        }
    
        echo "</br> Primos é " ;
        foreach ($primos as $primo) {
            echo ", ".$primo;
        }


        $dados = [
          "valores"=>$valores,
          "inicio"=>$inicio,
          "fim"=>$fim,
          "numeros"=>$numeros,
          "min"=>min($numeros),
          "max"=>max($numeros),
          "pares"=>$pares,
          "impares"=>$impares,
          "soma"=>$soma,
          "media"=>$media,
          "acima"=>$acima,
          "abaixo"=>$abaixo,
          "primos"=>$primos
        ];
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
 
<div id = "container" style = "width: 550px; height: 400px; margin: 0 auto"></div>
<script language = "JavaScript">
         function drawChart() {
            
            var jsonData = JSON.parse($.ajax({
              url: "dados.php",
              dataType: "json",
              async: false
            }).responseText);
            console.log(jsonData);
            
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'sequência');
            data.addColumn('number', 'elemento');
            data.addColumn('number', 'média');
            data.addColumn('number', 'inicio');
            data.addColumn('number', 'fim');
            data.addColumn('number', 'maior');
            data.addColumn('number', 'menor');
            var vals = [];
            jsonData["numeros"].forEach(el => vals.push([String(el), el, jsonData["media"], jsonData["inicio"], jsonData["fim"], jsonData["max"], jsonData["min"]]));
            data.addRows(vals);
            console.log(vals);
               
            
            var options = {'title' : 'Dados aleatórios gerados',
               hAxis: {
                  title: 'sequência',
                  
               },
               vAxis: {
                  title: 'valor'
               },   
               'width':550,
               'height':400
            };

        
            var chart = new google.visualization.LineChart(document.getElementById('container'));
            chart.draw(data, options);
         }
         google.charts.setOnLoadCallback(drawChart);
      </script>
  
 

    
</form>
</body>
</html>