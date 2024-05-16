<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extensão Curricular</title>
    <style>
        /* Reset de estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #3c4043;
            margin: 0;
            padding: 0;
        }

        /* Barra de navegação */
        .navbar {
            background-color: orange; /* Altera a cor para laranja */
            color: #fff;
            height: 100px; /* Defina a altura desejada */
            margin-bottom: 20px; /* Defina a margem inferior desejada */
            padding: 10px;
            display: flex;
            justify-content: flex-start; /* Alinha à direita */
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
        }

        /* Conteúdo principal */
        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin: 20px;
        }

        .sidebar {
            width: 200px;
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #ccc;
        }

        .main-content {
            flex: 1;
            background-color: #fff;
            padding: 20px;
        }

        /* Links */
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            text-decoration: none;
            color: #3c4043;
        }

        /* Formulário de pesquisa */
        .search-form {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
        }

        .search-input {
            width: 150px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-button {
            padding: 8px 20px;
            background-color: #4285f4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

</head>
<body>
    <!-- Barra de navegação -->
    <div class="navbar">
        <a href="#" class="navbar-brand">Sistema de Extensão Curricular</a>
    </div>

    <!-- Conteúdo principal -->
    <div class="container">
        <!-- Barra lateral -->
        <div class="sidebar">
            <ul>
                <li><a href="#">Início</a></li>
                <li><a href="#">Turmas</a></li>
                <li><a href="#">Atividades</a></li>
                <li><a href="#">Perguntas</a></li>
                <li><a href="#">Notas</a></li>
            </ul>
        </div>

        <!-- Conteúdo principal -->
        <div class="main-content">
            <h1>Bem-vindo ao Sistema de Extensão Curricular</h1>
            <p>Este é um layout simples inspirado no Google Classroom.</p>

            <!-- Formulário de pesquisa -->
            <div class="search-form">
                <h2>Pesquisar Aluno</h2>
                <form action="#" method="GET">
                    <input type="text" name="search" class="search-input" placeholder="Digite o nome do aluno">
                    <button type="submit" class="search-button">Pesquisar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
