<?php
include('includes/auth.php'); // Garante que apenas usuários logados acessem
include('includes/db.php');
include('includes/header.php');

$mensagem = '';

// Lógica para Exclusão de Livros
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $livro_id = $_GET['id'];

    // Primeiro, busca os nomes dos arquivos para exclusão física
    $stmt_select = $conn->prepare("SELECT livro_pdf, capa FROM livros WHERE id = ?");
    $stmt_select->bind_param("i", $livro_id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    $livro_data = $result_select->fetch_assoc();
    $stmt_select->close();

    if ($livro_data) {
        $pdf_path = 'uploads/pdfs/' . $livro_data['livro_pdf']; // Caminho relativo à raiz
        $capa_path = 'uploads/capas/' . $livro_data['capa'];     // Caminho relativo à raiz

        // Tenta deletar os arquivos físicos
        if (file_exists($pdf_path) && !empty($livro_data['livro_pdf'])) {
            unlink($pdf_path); // Apaga o arquivo PDF
        }
        if (file_exists($capa_path) && !empty($livro_data['capa'])) {
            unlink($capa_path); // Apaga o arquivo de capa
        }

        // Agora, exclui o registro do banco de dados
        $stmt_delete = $conn->prepare("DELETE FROM livros WHERE id = ?");
        $stmt_delete->bind_param("i", $livro_id);
        if ($stmt_delete->execute()) {
            $mensagem = "<div class='mensagem success'><p>Livro excluído com sucesso!</p></div>";
        } else {
            $mensagem = "<div class='mensagem error'><p>Erro ao excluir livro do banco de dados: " . $conn->error . "</p></div>";
        }
        $stmt_delete->close();
    } else {
        $mensagem = "<div class='mensagem error'><p>Livro não encontrado para exclusão.</p></div>";
    }
}

// Consulta para buscar todos os livros para exibição
$res = $conn->query("SELECT id, titulo, autor, genero, capa, sinopse FROM livros ORDER BY titulo ASC");
?>

<h1 style="text-align: center; margin-top: 20px;">Gerenciar Livros</h1>
<?php echo $mensagem; ?>

<div style="text-align: center; margin-bottom: 20px;">
    <a href="upload_livro.php" class="btn-primary" style="padding: 8px 15px;">Adicionar Novo Livro</a>
    <a href="livros_lista.php" class="btn-secondary" style="padding: 8px 15px; background: #6c757d;">Todos os Livros</a>
</div>

<?php if ($res->num_rows > 0): ?>
    <table class="gerenciar-livros-tabela">
        <thead>
            <tr>
                <th>Capa</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Gênero</th>
                <th>Sinopse</th> <!-- Nova coluna -->
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($l = $res->fetch_assoc()): ?>
                <tr>
                    <td data-label="Capa" class="capa-celula">
                        <?php if ($l['capa']): ?>
                            <img src="uploads/capas/<?= htmlspecialchars($l['capa']) ?>" alt="<?= htmlspecialchars($l['titulo']) ?>" />
                        <?php else: ?>
                            <img src="https://via.placeholder.com/50x75?text=Sem+Capa" alt="Sem Capa" />
                        <?php endif; ?>
                    </td>
                    <td data-label="Título"><?= htmlspecialchars($l['titulo']) ?></td>
                    <td data-label="Autor"><?= htmlspecialchars($l['autor']) ?></td>
                    <td data-label="Gênero"><?= htmlspecialchars($l['genero']) ?></td>
                    <td data-label="Sinopse"><?= htmlspecialchars($l['sinopse']) ?></td> <!-- Nova célula -->
                    <td data-label="Ações" class="acoes-celula">
                        <a href="editar_livro.php?id=<?= $l['id'] ?>" class="btn-acao editar-btn">Editar</a>
                        <a href="?action=delete&id=<?= $l['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este livro? Esta ação é permanente.')" class="btn-acao excluir-btn">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align: center; margin-top: 30px; font-size: 1.2em; color: #666;">Nenhum livro cadastrado.</p>
<?php endif; ?>


<?php
$conn->close();
include('includes/footer.php');
?>