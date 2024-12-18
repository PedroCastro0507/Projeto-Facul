<?php
include($_SERVER['DOCUMENT_ROOT'] . '/conexao.php');


$item_id = isset($_GET['id']) ? intval($_GET['id']) : null;

$sql = "SELECT titulo, descricao, imagem FROM recursos WHERE id = $item_id";
$result = $conexao->query($sql);
$item = $result->fetch_assoc();
?>

<div class="card mb-3 shadow-lg">
    <div class="card-body">
        <h2 class="text-center mb-4"><?php echo htmlspecialchars($item['titulo']); ?></h2>
        <?php if ($item['imagem']): ?>
            <img src="<?php echo htmlspecialchars($item['imagem']); ?>" class="card-img-bottom rounded mx-auto d-block mb-4" style="max-width: 60rem;" alt="<?php echo htmlspecialchars($item['titulo']); ?>">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars($item['descricao'])); ?></p>
    </div>
</div>


<?php $conexao->close(); ?>
