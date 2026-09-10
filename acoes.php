<?php
require_once 'Class/Database.php';
require_once 'Class/Produto.php';

$db = (new Database())->getConnection();
$produtoObj = new Produto($db);
$acao = $_GET['acao'] ?? '';

if ($acao == 'adicionar') {
    $produtoObj->adicionar($_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['quantidade']);
    header("Location: index.php");
    exit;

} elseif ($acao == 'editar') {
    $produtoObj->editar($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['quantidade']);
    header("Location: index.php");
    exit;

} elseif ($acao == 'deletar') {
    $produtoObj->remover($_GET['id']);
    header("Location: index.php");
    exit;
}
?>