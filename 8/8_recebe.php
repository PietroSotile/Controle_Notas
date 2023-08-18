<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<div class="container text-center">
    <div class="container mt-4 text-center" id="invoice">
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            echo "<div class='container text-center mt-1 mb-5'>
            <h1 class='display-4'>Relatório de notas ".date('d/m/Y')."</h1>
            </div>";
            $valores = $_POST["notas"];
            $media = array();
            //var_dump($valores);
            echo "<table class='table table-hover text-center'><tr><th class='col bg-dark text-white' >Alunos</th>";
            for($i=0;$i<count($valores[0]['avaliacoes']);$i++){
                echo "<th class='col bg-dark text-white' >Avaliação ". $i+1 ."</th>";
            }
            echo "<th class='col bg-dark text-white' >Média</th>";
            echo "<th class='col bg-dark text-white' >Situação</th></tr>";
            for($j=0;$j<count($valores);$j++){
                $soma = 0;
                echo "<tr><td>".$valores[$j]['aluno']."</td>";
                for($k=0;$k<count($valores[$j]['avaliacoes']);$k++){
                    echo "<td>".$valores[$j]['avaliacoes'][$k]."</td>";
                    $soma = $soma + (int)$valores[$j]['avaliacoes'][$k];
                }
                $media[$j] = ceil($soma/count($valores[$j]['avaliacoes']));
                echo "<td>".$media[$j]."</td>";
                if($media[$j]>=70){
                    echo "<td class='bg-success text-white'>Aprovado</td></tr>";
                }
                else{
                    echo "<td class='bg-danger text-white'>Reprovado</td></tr>";
                }
            }
            echo "</table>";
        }
        else{
            header("Location: http://localhost/lista_3/8/8.html");
             exit();
        }
        ?>
    </div>
    <input type="button" class="btn btn-dark" id="download" value="Download PDF"></input>
</div>
<script>
    window.onload = function () {
    document.getElementById("download")
        .addEventListener("click", () => {
            const invoice = this.document.getElementById("invoice");
            console.log(invoice);
            console.log(window);
            var opt = {
                margin: 1,
                filename: 'relatorioNotas.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(invoice).set(opt).save();
        })
}
</script>