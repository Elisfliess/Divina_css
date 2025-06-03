<?php
session_start(); // Iniciar a sessão

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../css/painel.css">
</head>
<body>

    <div class="container">
        <div class="card">
            <a href="listar_administrador.php">
                <img src="../img/b1.png" alt="Administradores">
                <h3>Administradores</h3>
            </a>
        </div>
        <div class="card">
            <a href="listar_categorias.php">
                <img src="../img/b2.png" alt="Categorias">
                <h3>Categorias</h3>
            </a>
        </div>
        <div class="card">
            <a href="listar_fornecedores.php">
                <img src="../img/b3.png" alt="Fornecedores">
                <h3>Fornecedores</h3>
            </a>
        </div>
        <div class="card">
            <a href="listar_produtos.php">
                <img src="../img/b4.png" alt="Produtos">
                <h3>Produtos</h3>
            </a>
        </div>
        <div class="card">
            <a href="listar_subcategorias.php">
                <img src="../img/b5.png" alt="Subcategorias">
                <h3>Subcategorias</h3>
            </a>
        </div>
    </div>

    <br><br>
    <a href="../E-commerce/index.html">
        <button class="logout-btn">Logout</button>
    </a>

</body>
</html>
