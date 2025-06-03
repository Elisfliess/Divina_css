<?php
// Inicia a sessão para gerenciamento do usuário.
session_start();

// Importa a configuração de conexão com o banco de dados.
require_once('conexao_azure.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];

 // Validação: campo obrigatório
 if (empty($nome)) {
    echo "<p style='color:red;'>O nome da categoria é obrigatório.</p>";
    exit();
}

// Verifica se a categoria já existe (case insensitive)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM categoria WHERE LOWER(nome) = LOWER(:nome)");
$stmt->bindParam(':nome', $nome);
$stmt->execute();

if ($stmt->fetchColumn() > 0) {
    echo "<p style='color:red;'>Esta categoria já está cadastrada.</p>";
    exit();
}

    // Inserindo categoria no banco.
    try {
        $sql = "INSERT INTO categoria (nome) VALUES (:nome);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->execute();

        echo "<p style='color:green;'>Categoria cadastrada com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar Categoria: " . $e->getMessage() . "</p>";
    }
}
?>


<!-- Início do código HTML -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Categoria</title>
    <link rel="stylesheet" href="../css/menuhamburguer.css">
 <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .cubo {
            background-color: white;
            border: 2px solid #9E7FAF;
            border-radius: 15px;
            padding: 30px 40px;
            width: 400px;
            box-shadow: 0px 0px 20px rgba(158, 127, 175, 0.3);
        }

        .cubo h2 {
            text-align: center;
            color: #9E7FAF;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            background-color: #9E7FAF;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #7e5f90;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #9E7FAF;
            text-decoration: none;
            display: inline-block;
            margin: 5px 0;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>




<!-- MENU HAMBURGUER-->


<div class="hamburguer">
        <button class="menu-btn">&#9776;</button>
        <img class="imglogo" src="../img/Logo.png" alt="Logo" class="logo">
        <nav class="nav">
            <ul>
                <li class="category"><a href="#">ADMINISTRADOR</a>
                    <ul class="submenu">
                        <li><a href="./listar_administrador.php">LISTAR</a></li>
                        <li><a href="./cadastrar_administrador.php">CADASTRAR</a></li>
                    </ul>
                </li>
                <li class="category"><a href="#">CATEGORIA</a>
                    <ul class="submenu">
                        <li><a href="listar_categorias.php">LISTAR</a></li>
                        <li><a href="./cadastrar_categorias.php">CADASTRAR</a></li>
                       
                    </ul>
                </li>
                <li class="category"><a href="#">FORNECEDOR</a>
                    <ul class="submenu">
                        <li><a href="listar_fornecedores.php">LISTAR</a></li>
                        <li><a href="./cadastrar_fornecedores.php">CADASTRAR</a></li>
                       
                    </ul>
                </li>
                <li class="category"><a href="#">PRODUTO</a>
                    <ul class="submenu">
                        <li><a href="listar_produtos.php">LISTAR</a></li>
                        <li><a href="./cadastrar_produtos.php">CADASTRAR</a></li>
                        
                    </ul>
                </li>
                <li class="category"><a href="#">SUBCATEGORIA</a>
                    <ul class="submenu">
                        <li><a href="listar_subcategorias.php">LISTAR</a></li>
                        <li><a href="./cadastrar_subcategorias.php">CADASTRAR</a></li>
                        
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <script>
        const menuBtn = document.querySelector('.menu-btn');
        const nav = document.querySelector('.nav');

        menuBtn.addEventListener('click', () => {
            nav.classList.toggle('active');
        });
    </script>

<!-- CADASTRAR ADMINISTRADOR -->


<h2>Cadastrar Categoria</h2>
<form action="" method="post" enctype="multipart/form-data">
    <!-- Campos do formulário para inserir informações do administrador -->
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>
    <p>

    <p>
    <button type="submit">Cadastrar Categoria</button>
    <!-- Se você omitir o atributo type em um elemento <button> dentro de um formulário, o navegador assumirá por padrão que o botão é do tipo submit. Isso significa que, ao clicar no botão, o formulário ao qual o botão pertence será enviado. Mas é boa prática especificá-lo-->

    <p></p>
    <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    <br>
    <a href="listar_categorias.php">Listar Categoria</a>

</form>
</body>
</html>
