<?php
session_start(); // Inicia a sessão para que o header possa verificar o status de login
include('includes/db.php');
include('includes/header.php');

$res = $conn->query("SELECT id, titulo, autor, ano_publicacao, genero, capa FROM livros ORDER BY titulo ASC");
?>
    <h1 style="text-align: center; margin-top: 20px;">Todos os Livros</h1>


    <div class="livros-grid">
        <?php if ($res->num_rows > 0): ?>
            <?php while($l = $res->fetch_assoc()): ?>
                <div class="livro-item">
                    <a href="livro.php?id=<?= $l['id'] ?>">
                        <?php if ($l['capa']): ?>
                            <img src="uploads/capas/<?= htmlspecialchars($l['capa']) ?>" alt="<?= htmlspecialchars($l['titulo']) ?>" />
                        <?php else: ?>
                            <img src="https://via.placeholder.com/150x200?text=Sem+Capa" alt="Sem Capa" />
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($l['titulo']) ?></h3>
                        <p>Autor: <?= htmlspecialchars($l['autor']) ?></p>
                        <p>Ano: <?= htmlspecialchars($l['ano_publicacao']) ?></p>
                        <p>Gênero: <?= htmlspecialchars($l['genero']) ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">Nenhum livro cadastrado ainda.</p>
        <?php endif; ?>
    </div>

<?php
$conn->close();
include('includes/footer.php');
?>