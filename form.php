<?php
require_once 'Class/Database.php';
require_once 'Class/Produto.php';

$db = (new Database())->getConnection();
$produtoObj = new Produto($db);

$id = $_GET['id'] ?? null;
$produto = null;

// Se tem ID, busca o produto para preencher (Modo Edição)
if ($id) {
    $produto = $produtoObj->buscarPorId($id);
}

$acao = $produto ? 'editar' : 'adicionar';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $produto ? 'Editar Produto' : 'Novo Produto' ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #000080; margin-top: 0; border-bottom: 2px solid #000080; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { display: inline-block; padding: 10px 20px; color: #fff; background-color: #000080; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 16px; }
        .btn:hover { background-color: #000050; }
        .btn-secondary { background-color: #6c757d; margin-left: 10px; }
        .btn-secondary:hover { background-color: #5a6268; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $produto ? 'Editar Produto' : 'Cadastrar Novo Produto' ?></h1>
        
        <form action="acoes.php?acao=<?= $acao ?>" method="POST">
            <?php if ($produto): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label>Nome do Produto:</label>
                <input type="text" name="nome" value="<?= $produto ? htmlspecialchars($produto['nome']) : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label>Descrição:</label>
                <textarea name="descricao" rows="4"><?= $produto ? htmlspecialchars($produto['descricao']) : '' ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Preço Unitário (R$):</label>
                <input type="number" step="0.01" name="preco" value="<?= $produto ? htmlspecialchars($produto['preco']) : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label>Quantidade em Estoque:</label>
                <input type="number" name="quantidade" value="<?= $produto ? htmlspecialchars($produto['quantidade']) : '' ?>" required>
            </div>
            
            <div style="margin-top: 25px;">
                <button type="submit" class="btn">Salvar Produto</button>
                <a href="index.php" class="btn btn-secondary">Cancelar / Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>