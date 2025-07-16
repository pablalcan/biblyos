<?php
session_start(); // Inicia a sessão para verificar se o usuário está logado
include('includes/db.php');
include('includes/header.php');

// Exemplo de como pegar alguns livros recentes para a página inicial
$res = $conn->query("SELECT id, titulo, autor, capa FROM livros ORDER BY id DESC LIMIT 6"); // Pega os 6 livros mais recentes
?>
    <h1 style="text-align: center; margin-top: 20px;">Bem-vindo à BIBLYOS!</h1>
    <p style="text-align: center; font-size: 1.1em; color: #555;">Sua biblioteca digital colaborativa. Encontre e compartilhe livros.</p>

    <h2 style="text-align: center; margin-top: 40px;">Últimos Livros Adicionados</h2>
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
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">Nenhum livro adicionado ainda. Seja o primeiro a <a href="upload_livro.php">enviar um livro</a>!</p>
        <?php endif; ?>
    </div>

<?php
$conn->close();
include('includes/footer.php');
?>