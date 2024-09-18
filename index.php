<!-- Conexão com o banco de dados -->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "crud_pedidos_gaucho";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn-> connect_error) {
        die("Conexão falhou:" . $conn-> connect_error);
    }

// CREATE
    if(isset($_POST['create'])) {
        $nome_cliente = $_POST['nome_cliente'];
        $quantidade = $_POST['quantidade'];
        $nome_produto = $_POST['nome_produto'];
        $data = $_POST['data'];
        $sql = "INSERT INTO pedidos (nome_cliente_pedidos, quantidade_pedidos, nome_produto_pedidos, data_entrega_produto_pedidos) VALUE ('$nome_cliente', '$quantidade', '$nome_produto', '$data')";
        if($conn -> query($sql) === TRUE) {
            header("Refresh:0; url=index.php");
        } else {
            echo "Erro: " . $sql . "<br>". $conn -> error;
        }
    }

// DELETE
    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sql = "DELETE FROM pedidos WHERE id_pedidos = '$id'";
        if($conn -> query($sql) === TRUE) {
            header("Refresh:0; url=index.php");
        } else {
            echo "Erro: " . $sql . "<br>". $conn -> error;
        }
    }
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Pedidos</title>
</head>
<body id="body">
    <h1>Visualize os pedidos</h1>
    <!-- Tabela pré-pronta do Bootstrap -->
    <div class="container my-4 div_separadora"></div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id_pedidos</th>
                    <th scope="col">nome_cliente_pedidos</th>
                    <th scope="col">quantidade_pedidos</th>
                    <th scope="col">nome_produto_pedidos</th>
                    <th scope="col">data_entrega_produto_pedidos</th>
                </tr>
            </thead>
            <tbody>
                <!-- READ -->
                <?php
                    $sql = "SELECT * FROM pedidos";
                    $result = $conn -> query($sql);
                    // Loop para mostrar todos os dados cadastrados no banco
                    if ($result -> num_rows > 0) {
                        while ($row = $result -> fetch_assoc()) {
                            echo "<tr>
                            <th scope='row'> {$row['id_pedidos']} </th>
                            <td>{$row['nome_cliente_pedidos']}</td>
                            <td>{$row['quantidade_pedidos']}</td>
                            <td>{$row['nome_produto_pedidos']}</td>
                            <td>{$row['data_entrega_produto_pedidos']}</td>
                            <td>
                                <a href='index.php?update={$row['id_pedidos']}'>Editar</a> |
                                <a href='index.php?delete={$row['id_pedidos']}'>Excluir</a>
                            </td>
                            </tr>";
                        }
                    } else {
                        echo "Nenhum registro encontrado";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="div_separadora_create">
        <h1>Criar pedido</h1>
        <form method="POST">
            <label for="nome_cliente">Nome do Cliente:</label>
            <input type="text" name="nome_cliente" required>
            <br>
            <label for="quantidade">Quantidade do produto:</label>
            <input type="number" name="quantidade" required>
            <br>
            <label for="nome_produto">Nome do produto:</label>
            <input type="text" name="nome_produto" required>
            <br>
            <label for="data">Data de entrega:</label>
            <input type="date" name="data" required>
            <br>
            <br>
            <input type="submit" name="create" value="Adicionar">
        </form>
    </div>
<?php
// UPDATE
if(isset($_GET['update'])) {
    $id = $_GET['update'];
    if(isset($_POST['update'])) {
        $nome_cliente = $_POST['nome_cliente'];
        $quantidade = $_POST['quantidade'];
        $nome_produto = $_POST['nome_produto'];
        $data = $_POST['data'];
        $sql = "UPDATE pedidos SET nome_cliente_pedidos = '$nome_cliente', quantidade_pedidos = '$quantidade', nome_produto_pedidos = '$nome_produto', data_entrega_produto_pedidos = '$data' WHERE id_pedidos = '$id'"; 
        if($conn -> query($sql) === TRUE) {
            header("Refresh:0; url=index.php");
        } else {
            echo "Erro: " . $sql . "<br>". $conn -> error;
        }
    }
    $sql = "SELECT * FROM pedidos WHERE id_pedidos = '$id'";
    $result = $conn -> query($sql);
    $row = $result -> fetch_assoc();
}  
?>
<?php
    if (isset($_GET['update'])) {
        ?>
        <div class="div_separadora_update">
        <h1>Atualizar pedido</h1>
        <form method="POST" action="index.php?update=<?php echo $row['id_pedidos'];?>">
            <label for="nome_cliente">Nome do Cliente:</label>
            <input type="text" name="nome_cliente" value="<?php echo $row['nome_cliente_pedidos'];?>" required>
            <br>
            <label for="quantidade">Quantidade do produto:</label>
            <input type="number" name="quantidade" value="<?php echo $row['quantidade_pedidos'];?>" required>
            <br>
            <label for="nome_produto">Nome do produto:</label>
            <input type="text" name="nome_produto" value="<?php echo $row['nome_produto_pedidos'];?>" required>
            <br>
            <label for="data">Data de entrega:</label>
            <input type="date" name="data" value="<?php echo $row['data_entrega_produto_pedidos'];?>" required>
            <br>
            <br>
            <input type="submit" name="update" value="Atualizar">
        </form>
    </div>
    <?php
    } else {
    }
?>
</body>
</html>