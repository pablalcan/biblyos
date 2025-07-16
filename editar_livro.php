<?php
include('includes/auth.php'); // Garante que apenas usuários logados acessem
include('includes/db.php');
include('includes/header.php');

$livro = null;
$mensagem = '';
$livro_id = null;

// Lógica para carregar os dados do livro a ser editado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $livro_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM livros WHERE id = ?");
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $livro = $result->fetch_assoc();
    } else {
        $mensagem = "<div class='mensagem error'><p>Livro não encontrado.</p></div>";
    }
    $stmt->close();
} else if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se não houver ID na URL e não for um POST, redireciona de volta
    header('Location: gerenciar_livros.php');
    exit;
}

// Lógica para processar o formulário de edição (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['livro_id'])) {
    $livro_id = $_POST['livro_id'];
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $ano_publicacao = $_POST['ano_publicacao'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';

    // Variáveis para manter os nomes de arquivo atuais se nenhum novo for enviado
    $livro_pdf_nome = $_POST['livro_pdf_atual'] ?? '';
    $capa_nome = $_POST['capa_atual'] ?? '';

    // Lógica para upload de NOVOS arquivos (PDF)
    if (isset($_FILES['livro_pdf']) && $_FILES['livro_pdf']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/pdfs/';
        $livro_pdf_tmp_name = $_FILES['livro_pdf']['tmp_name'];
        $extensao = pathinfo($_FILES['livro_pdf']['name'], PATHINFO_EXTENSION);
        $novo_livro_pdf_nome = uniqid() . '_' . strtolower(preg_replace("/[^a-zA-Z0-9_.-]/", "", pathinfo($_FILES['livro_pdf']['name'], PATHINFO_FILENAME))) . '.' . $extensao;
        $livro_pdf_destino = $upload_dir . $novo_livro_pdf_nome;

        if (move_uploaded_file($livro_pdf_tmp_name, $livro_pdf_destino)) {
            // Se um novo PDF foi enviado, apaga o antigo se existir
            if (!empty($_POST['livro_pdf_atual']) && file_exists($upload_dir . $_POST['livro_pdf_atual'])) {
                unlink($upload_dir . $_POST['livro_pdf_atual']);
            }
            $livro_pdf_nome = $novo_livro_pdf_nome;
        } else {
            $mensagem = "<div class='mensagem error'><p>Erro ao fazer upload do novo PDF.</p></div>";
        }
    } else if (isset($_FILES['livro_pdf']) && $_FILES['livro_pdf']['error'] !== UPLOAD_ERR_NO_FILE) {
        $mensagem = "<div class='mensagem error'><p>Erro no upload do PDF: Código " . $_FILES['livro_pdf']['error'] . "</p></div>";
    }

    // Lógica para upload de NOVOS arquivos (Capa)
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $upload_dir_capas = 'uploads/capas/';
        $capa_tmp_name = $_FILES['capa']['tmp_name'];
        $extensao_capa = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $nova_capa_nome = uniqid() . '_' . strtolower(preg_replace("/[^a-zA-Z0-9_.-]/", "", pathinfo($_FILES['capa']['name'], PATHINFO_FILENAME))) . '.' . $extensao_capa;
        $capa_destino = $upload_dir_capas . $nova_capa_nome;

        if (move_uploaded_file($capa_tmp_name, $capa_destino)) {
            // Se uma nova capa foi enviada, apaga a antiga se existir
            if (!empty($_POST['capa_atual']) && file_exists($upload_dir_capas . $_POST['capa_atual'])) {
                unlink($upload_dir_capas . $_POST['capa_atual']);
            }
            $capa_nome = $nova_capa_nome;
        } else {
            $mensagem = "<div class='mensagem error'><p>Erro ao fazer upload da nova capa.</p></div>";
        }
    } else if (isset($_FILES['capa']) && $_FILES['capa']['error'] !== UPLOAD_ERR_NO_FILE) {
        $mensagem = "<div class='mensagem error'><p>Erro no upload da capa: Código " . $_FILES['capa']['error'] . "</p></div>";
    }

    // Atualiza os dados no banco de dados
    if (empty($mensagem) && !empty($titulo) && !empty($autor) && !empty($ano_publicacao) && !empty($livro_pdf_nome)) { // Garante que os campos obrigatórios não estão vazios
        $stmt = $conn->prepare("UPDATE livros SET titulo = ?, autor = ?, ano_publicacao = ?, genero = ?, sinopse = ?, livro_pdf = ?, capa = ? WHERE id = ?");
        $stmt->bind_param("ssissssi", $titulo, $autor, $ano_publicacao, $genero, $sinopse, $livro_pdf_nome, $capa_nome, $livro_id);

        if ($stmt->execute()) {
            $mensagem = "<div class='mensagem success'><p>Livro atualizado com sucesso!</p></div>";
            // Recarrega os dados do livro para exibir as informações atualizadas no formulário
            $stmt_recarregar = $conn->prepare("SELECT * FROM livros WHERE id = ?");
            $stmt_recarregar->bind_param("i", $livro_id);
            $stmt_recarregar->execute();
            $livro = $stmt_recarregar->get_result()->fetch_assoc();
            $stmt_recarregar->close();

        } else {
            $mensagem = "<div class='mensagem error'><p>Erro ao atualizar livro no banco de dados: " . $conn->error . "</p></div>";
        }
        $stmt->close();
    } else if (empty($mensagem)) { // Se não houve erro de upload mas faltou algum campo obrigatório
        $mensagem = "<div class='mensagem error'><p>Por favor, preencha todos os campos obrigatórios (Título, Autor, Ano de Publicação e Arquivo PDF).</p></div>";
    }
}
$conn->close();
?>

<h1 style="text-align: center; margin-top: 20px;">Editar Livro</h1>
<?php echo $mensagem; ?>

<?php if ($livro): ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="livro_id" value="<?= htmlspecialchars($livro['id']) ?>">
        <input type="hidden" name="livro_pdf_atual" value="<?= htmlspecialchars($livro['livro_pdf'] ?? '') ?>">
        <input type="hidden" name="capa_atual" value="<?= htmlspecialchars($livro['capa'] ?? '') ?>">

        <div class="upload-form-group">
            <label for="titulo">Título do Livro:</label>
            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($livro['titulo']) ?>" required>
        </div>
        <div class="upload-form-group">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($livro['autor']) ?>" required>
        </div>
        <div class="upload-form-group">
            <label for="ano_publicacao">Ano de Publicação:</label>
            <input type="number" id="ano_publicacao" name="ano_publicacao" min="1000" max="<?= date('Y') + 1 ?>" value="<?= htmlspecialchars($livro['ano_publicacao']) ?>" required>
        </div>
        <div class="upload-form-group">
            <label for="genero">Gênero:</label>
            <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($livro['genero']) ?>">
        </div>
        <div class="upload-form-group">
            <label for="sinopse">Sinopse:</label>
            <textarea id="sinopse" name="sinopse" rows="5"><?= htmlspecialchars($livro['sinopse']) ?></textarea>
        </div>

        <div class="upload-form-group">
            <label for="livro_pdf">Arquivo PDF do Livro (deixe em branco para manter o atual):</label>
            <?php if ($livro['livro_pdf']): ?>
                <p>PDF atual: <a href="uploads/pdfs/<?= htmlspecialchars($livro['livro_pdf']) ?>" target="_blank"><?= htmlspecialchars($livro['livro_pdf']) ?></a></p>
            <?php else: ?>
                <p>Nenhum PDF atual. Um arquivo PDF é obrigatório para este livro.</p>
            <?php endif; ?>
            <input type="file" id="livro_pdf" name="livro_pdf" accept="application/pdf">
        </div>
        <div class="upload-form-group">
            <label for="capa">Capa do Livro (Imagem - deixe em branco para manter a atual):</label>
            <?php if ($livro['capa']): ?>
                <p>Capa atual: <img src="uploads/capas/<?= htmlspecialchars($livro['capa']) ?>" alt="Capa atual" style="max-width: 100px; height: auto; display: block; margin-top: 5px;"></p>
            <?php else: ?>
                <p>Nenhuma capa atual.</p>
            <?php endif; ?>
            <input type="file" id="capa" name="capa" accept="image/*">
        </div>
        <button type="submit">Atualizar Livro</button>
        <p style="text-align: center; margin-top: 15px;"><a href="gerenciar_livros.php" style="background: none; color: #007bff; padding: 0; text-decoration: underline; font-weight: normal;">Voltar para Gerenciar Livros</a></p>
    </form>
<?php else: ?>
    <p style="text-align: center; margin-top: 50px; font-size: 1.2em; color: #666;">Livro não encontrado para edição.</p>
    <p style="text-align: center;"><a href="gerenciar_livros.php">Voltar para a lista de gerenciamento</a></p>
<?php endif; ?>

<?php include('includes/footer.php'); ?>
