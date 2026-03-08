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

    <form method="POST">
        <button type="submit" name="btn_video1">Vídeo1</button>
        <span>Com PHP</span>
    </form>

    <button type="button" onclick="window.location.href='https://www.youtube.com/watch?v=Yl5q96YE22s'">Vídeo2</button>
    <span>Com JS</span>

    <br>

    <a href="https://www.youtube.com/watch?v=YCXtaBXgP5A&t=12s">
        <button type="submit">Vídeo3</button>
    </a>
    <span>Com HTML</span>

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
                echo "<li>".$dados['nome'];
                echo "<form method='POST' style='display:inline;'>";
                echo "<input type='hidden' name='excluir_id' value='" . $dados['id'] . "'>";
                echo "<button type='submit'>[X]</button>";
                echo "</form></li>";
            }
            echo "</ul>";
        }

    ?>
</body>
</html>