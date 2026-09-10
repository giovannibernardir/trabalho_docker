<?php
require_once 'Class/Database.php';
require_once 'Class/Produto.php';

$db = (new Database())->getConnection();
$produtoObj = new Produto($db);
$produtos = $produtoObj->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; margin: 0; padding: 40px; }
        .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #000080; border-bottom: 2px solid #000080; padding-bottom: 10px; }
        .btn { display: inline-block; padding: 10px 15px; color: #fff; background-color: #000080; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-weight: bold; }
        .btn:hover { background-color: #000050; }
        .btn-danger { background-color: #d9534f; }
        .btn-danger:hover { background-color: #c9302c; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #000080; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .actions a { margin-right: 10px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meus Produtos</h1>
        <a href="form.php" class="btn">Adicionar Novo Produto</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço (R$)</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produtos)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 20px;">Nenhum produto cadastrado no momento.</td></tr>
                <?php else: ?>
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['id']) ?></td>
                            <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                            <td><?= htmlspecialchars($p['descricao']) ?></td>
                            <td><?= number_format($p['preco'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($p['quantidade']) ?> un.</td>
                            <td class="actions">
                                <a href="form.php?id=<?= $p['id'] ?>" class="btn">Editar</a>
                                <a href="acoes.php?acao=deletar&id=<?= $p['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>