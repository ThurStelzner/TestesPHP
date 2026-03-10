<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_video1'])) {
        header('Location: https://www.youtube.com/watch?v=V5XjDpBhlLI');
        exit();
    }

    $arquivo = 'dados.json';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dados'])) {
            $dado = ["id" => time(), "nome" => $_POST['dados']];

            if (file_exists($arquivo)) {
                $conteudo = file_get_contents($arquivo);
                $lista = json_decode($conteudo, true);
            } else {
                $lista = [];
            }

            $lista[] = $dado;
            $texto_json = json_encode($lista, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            file_put_contents($arquivo, $texto_json);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir_id'])) {
        $id_apagar = $_POST['excluir_id']; // Pega o ID do botão

        if (file_exists($arquivo)) {
            $lista = json_decode(file_get_contents($arquivo), true);

            // O PHP procura item por item
            foreach ($lista as $chave => $item) {
                // Se o ID do item for igual ao ID que o botão enviou...
                if ($item['id'] == $id_apagar) {
                    unset($lista[$chave]); // Destrói o item!
                    break; // Para de procurar
                }
            }

            // Salva o arquivo atualizado
            file_put_contents($arquivo, json_encode($lista, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            // Recarrega a página
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testes</title>
    <style>
        li {
            margin-left: -35px;
            list-style: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Testes/Aula PHP</h1>
    <h2>Teste de if & else</h2>
    <form method="POST">
        <p>Nome
            <input type="text" name="nome" placeholder="Seu nome aqui" required>
        </p>
        <p>Senha
            <input type="password" name="senha" placeholder="Não obrigarório">
        </p>
        <button type="submit" name="btn_ifelse">Enviar</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btn_ifelse'])) {
            $nome = $_POST['nome'];
            $senha = $_POST['senha'];
            if ($nome == 'Arthur' and $senha == '123') {
                echo "Olá ".$nome." criador!";
            } else {
                echo "Olá ".$nome."";
            }
        }
    ?>
    <h2>Teste redirecionamento</h2>
    <ul>
        <li>
            <form method="POST">
                <button type="submit" name="btn_video1">Vídeo1</button>
                <span>Com PHP</span>
            </form>
        </li>
        <li>
            <button type="button" onclick="window.location.href='https://www.youtube.com/watch?v=Yl5q96YE22s'">Vídeo2</button>
            <span>Com JS</span>
        </li>
        <li>
            <a href="https://www.youtube.com/watch?v=YCXtaBXgP5A&t=12s">
                <button type="submit">Vídeo3</button>
            </a>
            <span>Com HTML</span>
        </li>
    </ul>
    <h3>Explicações</h3>
    <p>O <span style="color: purple;">isset()</span> vem do inglês <span style="color: red;">"is set"</span>, que significa <span style="color: red;">"está definido?"</span> ou <span style="color: red;">"existe?"</span></p>
    <p>Em resumo serve para verificar duas coisas ao mesmo tempo</p>
    <p>O php de redirecionamento tem que estar acima do doctype para que nao haja erros de carregamento</p>

    <h2>Arquivo JSON</h2>
    <form method="POST">
        <input type="text" name="dados" placeholder="Seu dado aqui" required>
        <button type="submit">Enviar</button>
    </form>
    <?php

        if (file_exists($arquivo)) {
            $mostrar_dados = file_get_contents($arquivo);
            $dados_salvos = json_decode($mostrar_dados, true);

            echo "<ul>";
            foreach ($dados_salvos as $dados) {
                echo "<li style = margin-top:10px;>".$dados['nome'];
                echo "<form method='POST' style='display:inline;'>";
                echo "<input type='hidden' name='excluir_id' value='" . $dados['id'] . "'>";
                echo "<button type='submit'>[X]</button>";
                echo "</form></li>";
            }
            echo "</ul>";
        }

    ?>
    <h2>Calculadora PHP</h2>
    <form method="POST">
        <p>1º número
            <input type="number" name="num1" min='0' step="any" placeholder="0" required>
        </p>
        <p>Operação 
            <select name="operacao">
                <option value="0">+</option>
                <option value="1">-</option>
                <option value="2">/</option>
                <option value="3">x</option>
                <option value="4">^</option>
                <option value="5">√</option>
            </select>
        </p>
        <p>2º número
            <input type="number" name="num2" min='0' step="any" placeholder="0">
        </p>
        <button type="submit" name="btn_calculadora">Calcular</button>
    </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btn_calculadora'])) {
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $operacao = $_POST['operacao'];
            $total = null;

            switch ($operacao) {
                case "0":
                    $total = $num1 + $num2;
                    break;
                case "1":
                    $total = $num1 - $num2;
                    break;
                case "2":
                    $total = ($num2 = 0) ? ($num1 / $num2): "Não é possível dividir por 0";
                    break;
                case "3":
                    $total = $num1 * $num2;
                    break;
                case "4":
                    $total = $num1 ** $num2;
                    break;  
                case "5":
                    // empty() verifica se o campo está vazio // sqrt() faz a raiz quadrada "square root"
                    $total = (empty($_POST['num2'])) ? (sqrt($num1)): "Digite a raiz apenas no primeiro campo";
                    break;                
            }
            echo "<h3>Resultado: $total</h3>";
        }
    ?>
    <h2>Calcular temperatura</h2>
    <form method="POST">
        <p>Converter
            <select name="temperatura1">
                <option value="0">Celcius</option>
                <option value="1">Fahrenheit</option>
            </select>
        </p>
        <p>Temperatura
            <input type="number" name="valor" placeholder="35º" required>
        </p>
        <p>Para <span id="destino">Fahrenheit</span></p>
        <button name="btn_temperatura">Converter</button>
    </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btn_temperatura'])) {
            $temp1 = $_POST['temperatura1'];
            $valor = $_POST['valor'];
            $simbolo = null;
            $resultado = 0;

            switch ($temp1) {
                case "0":
                    $resultado = ($valor * 1.8) + 32;
                    $simbolo = "ºF";
                    break;
                case "1":
                    $resultado = ($valor - 32) / 1.8;
                    $simbolo = "ºC";
                    break;
            }
            echo "<h3>Valor Convertido:" . number_format($resultado, 2, ",", ".") . $simbolo . "</h3>";
        }
    ?>
    <h2>Verificação de idade</h2>
    <form method="POST">
        <input type="number" name="idade" placeholder="Digite sua idade" required>
        <button type="submit" name="btn_idade">Enviar</button>
    </form>
    <?php
        $idade = $_POST['idade'];
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btn_idade'])) {
                if ($idade > 18) {
                    echo "<h3>Você é maior de idade</h3>";
                } elseif ($idade <= 0) {
                    echo "<span style='color:red;'>Idade inválida</span>";
                } else {
                    echo "<h3>Você é menor de idade</h3>";
                }
        }
    ?>
<script>
    // Seleciona o campo select
    const seletor = document.querySelector('select[name="temperatura1"]');
    // Seleciona o local onde queremos mudar o texto
    const destino = document.getElementById('destino');
    // Adiciona um "ouvinte" de eventos 
    seletor.addEventListener('change', function() {
        if (this.value === "0") {
            destino.innerText = "Fahrenheit";
        } else {
            destino.innerText = "Celsius";
        }
    });
</script>
</body>
</html>