<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

include('includes/db.php');
include('includes/header.php');

$livro_id = $_GET['id'] ?? 0;

if ($livro_id) {
    $stmt = $conn->prepare("SELECT * FROM livros WHERE id = ?");
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $livro = $result->fetch_assoc();
    } else {
        $livro = null;
    }
    $stmt->close();
} else {
    $livro = null;
}
$conn->close();
?>
    <h1 style="text-align: center; margin-top: 20px;">Detalhes do Livro</h1>

    <?php if ($livro): ?>
    <div class="livro-detalhes">
        <div class="livro-carrossel">
            <div class="carrossel-inner">
                <div class="carrossel-slide active" data-slide-id="capa">
                    <?php if ($livro['capa']): ?>
                        <img src="uploads/capas/<?= htmlspecialchars($livro['capa']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" />
                    <?php else: ?>
                        <img src="https://via.placeholder.com/250x380?text=Sem+Capa" alt="Sem Capa" />
                    <?php endif; ?>
                </div>

                <div class="carrossel-slide" data-slide-id="sinopse">
                    <h3 class="slide-title">Sinopse</h3>
                    <?php if (!empty($livro['sinopse'])): ?>
                        <div class="sinopse-texto"><?= nl2br(htmlspecialchars($livro['sinopse'])) ?></div>
                    <?php else: ?>
                        <p class="mensagem info">Nenhuma sinopse disponível para este livro.</p>
                    <?php endif; ?>
                </div>
            </div>
            <button class="btn-virar-pagina" id="btn-virar-pagina">
                <span>&gt;</span> </button>
        </div>

        <div class="livro-info">
            <h2><?= htmlspecialchars($livro['titulo']) ?></h2>
            <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
            <p><strong>Ano de Publicação:</strong> <?= htmlspecialchars($livro['ano_publicacao']) ?></p>
            <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero']) ?></p>
            
            <?php if ($livro['livro_pdf']): ?>
                <div class="livro-acoes">
                    <a href="uploads/pdfs/<?= htmlspecialchars($livro['livro_pdf']) ?>" target="_blank" class="btn-primary">Ler Online (PDF)</a>
                    <a href="uploads/pdfs/<?= htmlspecialchars($livro['livro_pdf']) ?>" download class="btn-secondary">Download (PDF)</a>
                </div>
            <?php else: ?>
                <p class="mensagem info">Nenhum arquivo PDF disponível para este livro.</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="livro-acoes">
                    <p>Ações para usuários logados:</p>
                    <a href="editar_livro.php?id=<?= $livro['id'] ?>" class="btn-info">Editar Livro</a>
                    <a href="gerenciar_livros.php?action=delete&id=<?= $livro['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este livro? Esta ação é permanente.')" class="btn-danger">Excluir Livro</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
        <p style="text-align: center; margin-top: 30px; font-size: 1.2em; color: #666;">Livro não encontrado.</p>
    <?php endif; ?>

    <script src="js/carrossel.js"></script> 
    <?php include('includes/footer.php'); ?>
