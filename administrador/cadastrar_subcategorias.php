<?php
// Inicia a sessão para gerenciamento do usuário.
session_start();

// Importa a configuração de conexão com o banco de dados.
//require_once('conexao.php');
require_once('conexao_azure.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}


// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idcategoria = $_POST['idcategoria'];
    $nome = $_POST['nome'];

    if (empty($nome)) {
        echo "<p style='color:red;'>O nome da categoria é obrigatório.</p>";
        exit();
    }
    
    // Verifica se a categoria já existe (case insensitive)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM subcategoria WHERE LOWER(nome) = LOWER(:nome)");
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        echo "<p style='color:red;'>Esta Subcategoria já está cadastrada.</p>";
        exit();
    }

    try {
        $sql = "INSERT INTO subcategoria (id_categoria, nome) VALUES (:idcategoria, :nome);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->execute();

        $sub_id = $pdo->lastInsertId();
        echo "<p style='color:green;'>Subcategoria cadastrada com sucesso! ID: " . $sub_id . "</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar Subcategoria: " . $e->getMessage() . "</p>";
    }
}

?>

<!-- Início do código HTML -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Subcategoria</title>
    <link rel="stylesheet" href="../css/menuhamburguer.css">
<style>
        body {
            margin: 0; padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #d5c6e0, #f0e6f5);
            height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }

        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4b2d5c;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #9E7FAF;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #7f6390;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #9E7FAF;
            font-weight: bold;
            transition: color 0.3s;
        }

        a:hover {
            color: #7f6390;
        }

        .mensagem {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            padding: 10px;
            border-radius: 6px;
        }

        .sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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


<h2>Cadastrar Subcategoria</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Campos do formulário para inserir informações do administrador -->
        <label for="idcategoria">Categoria:</label>
    <select name="idcategoria" id="idcategoria" required>
        <option value="">Selecione a categoria</option>
        <?php
        $stmt = $pdo->query("SELECT id_categoria, nome FROM categoria");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['id_categoria']}'>{$row['nome']}</option>";
        }
        ?>
    </select><br>
    <p>
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>
    <p>


    <p>
    <button type="submit">Cadastrar Subcategoria</button>
    <!-- Se você omitir o atributo type em um elemento <button> dentro de um formulário, o navegador assumirá por padrão que o botão é do tipo submit. Isso significa que, ao clicar no botão, o formulário ao qual o botão pertence será enviado. Mas é boa prática especificá-lo-->

    <p></p>
    <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    <br>
    <a href="listar_subcategorias.php">Listar Subcategoria</a>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const nomeInput = document.getElementById("nome");

        nomeInput.addEventListener("input", function() {
            // Remove caracteres que não sejam letras (incluindo acentuação) ou espaço
            this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');

        });
    });
</script>

</form>
</body>
</html>
