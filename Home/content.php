<?php
include($_SERVER['DOCUMENT_ROOT'] . '/conexao.php');    

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;

$sql = "SELECT id, titulo, descricao, imagem FROM recursos WHERE tipo = '$tipo' AND status = 'ativo'";
$result = $conexao->query($sql);
?>

<div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow">
                <?php if ($row['imagem']): ?>
                    <img src="<?php echo htmlspecialchars($row['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['titulo']); ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['titulo']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['descricao']); ?></p>
                    <a href="index.php?page=detail&id=<?php echo $row['id']; ?>" class="btn btn-primary">Ver mais</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php $conexao->close(); ?>
