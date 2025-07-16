<?php
include('includes/auth.php'); // Garante que apenas usuários logados podem acessar
include('includes/db.php');
include('includes/header.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $ano_publicacao = $_POST['ano_publicacao'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';

    $livro_pdf_nome = '';
    if (isset($_FILES['livro_pdf']) && $_FILES['livro_pdf']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/pdfs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $livro_pdf_tmp_name = $_FILES['livro_pdf']['tmp_name'];
        // Gerar um nome único para o arquivo PDF
        $extensao = pathinfo($_FILES['livro_pdf']['name'], PATHINFO_EXTENSION);
        $livro_pdf_nome = uniqid() . '_' . strtolower(preg_replace("/[^a-zA-Z0-9_.-]/", "", pathinfo($_FILES['livro_pdf']['name'], PATHINFO_FILENAME))) . '.' . $extensao;
        $livro_pdf_destino = $upload_dir . $livro_pdf_nome;

        if (!move_uploaded_file($livro_pdf_tmp_name, $livro_pdf_destino)) {
            $mensagem = "<div class='mensagem error'><p>Erro ao mover o arquivo PDF.</p></div>";
            $livro_pdf_nome = '';
        }
    } else if (isset($_FILES['livro_pdf']) && $_FILES['livro_pdf']['error'] !== UPLOAD_ERR_NO_FILE) {
         $mensagem = "<div class='mensagem error'><p>Erro no upload do PDF: Código " . $_FILES['livro_pdf']['error'] . "</p></div>";
    } else {
        $mensagem = "<div class='mensagem error'><p>O arquivo PDF é obrigatório para enviar um livro.</p></div>";
    }


    $capa_nome = '';
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $upload_dir_capas = 'uploads/capas/';
        if (!is_dir($upload_dir_capas)) {
            mkdir($upload_dir_capas, 0777, true);
        }
        $capa_tmp_name = $_FILES['capa']['tmp_name'];
        // Gerar um nome único para o arquivo de capa
        $extensao_capa = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $capa_nome = uniqid() . '_' . strtolower(preg_replace("/[^a-zA-Z0-9_.-]/", "", pathinfo($_FILES['capa']['name'], PATHINFO_FILENAME))) . '.' . $extensao_capa;
        $capa_destino = $upload_dir_capas . $capa_nome;

        if (!move_uploaded_file($capa_tmp_name, $capa_destino)) {
            $mensagem = "<div class='mensagem error'><p>Erro ao mover o arquivo de capa.</p></div>";
            $capa_nome = '';
        }
    } else if (isset($_FILES['capa']) && $_FILES['capa']['error'] !== UPLOAD_ERR_NO_FILE) {
        $mensagem = "<div class='mensagem error'><p>Erro no upload da capa: Código " . $_FILES['capa']['error'] . "</p></div>";
    }

    // Se não houve erros nos uploads E os campos obrigatórios estão preenchidos
    if (empty($mensagem) && !empty($titulo) && !empty($autor) && !empty($ano_publicacao) && !empty($livro_pdf_nome)) {
        $stmt = $conn->prepare("INSERT INTO livros (titulo, autor, ano_publicacao, genero, sinopse, livro_pdf, capa) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", $titulo, $autor, $ano_publicacao, $genero, $sinopse, $livro_pdf_nome, $capa_nome);

        if ($stmt->execute()) {
            $mensagem = "<div class='mensagem success'><p>Livro cadastrado com sucesso! <a href='livros_lista.php' style='background: none; color: #155724; padding: 0; text-decoration: underline; font-weight: bold;'>Ver todos os livros</a></p></div>";
        } else {
            $mensagem = "<div class='mensagem error'><p>Erro ao cadastrar o livro no banco de dados: " . $conn->error . "</p></div>";
        }
        $stmt->close();
    } else if (empty($mensagem)) { // Se não houve erro de upload mas faltou algum campo obrigatório
        $mensagem = "<div class='mensagem error'><p>Por favor, preencha todos os campos obrigatórios (Título, Autor, Ano de Publicação e Arquivo PDF).</p></div>";
    }
}
$conn->close();
?>
    <h1 style="text-align: center; margin-top: 20px;">Enviar Novo Livro</h1>
    <?php echo $mensagem; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="upload-form-group">
            <label for="titulo">Título do Livro:</label>
            <input type="text" id="titulo" name="titulo" required value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
        </div>
        <div class="upload-form-group">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required value="<?= htmlspecialchars($_POST['autor'] ?? '') ?>">
        </div>
        <div class="upload-form-group">
            <label for="ano_publicacao">Ano de Publicação:</label>
            <input type="number" id="ano_publicacao" name="ano_publicacao" min="1000" max="<?= date('Y') + 1 ?>" required value="<?= htmlspecialchars($_POST['ano_publicacao'] ?? '') ?>">
        </div>
        <div class="upload-form-group">
            <label for="genero">Gênero:</label>
            <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($_POST['genero'] ?? '') ?>">
        </div>
        <div class="upload-form-group">
            <label for="sinopse">Sinopse:</label>
            <textarea id="sinopse" name="sinopse" rows="5"><?= htmlspecialchars($_POST['sinopse'] ?? '') ?></textarea>
        </div>
        <div class="upload-form-group">
            <label for="livro_pdf">Arquivo PDF do Livro:<span style="color: red;">*</span></label>
            <input type="file" id="livro_pdf" name="livro_pdf" accept="application/pdf" required>
        </div>
        <div class="upload-form-group">
            <label for="capa">Capa do Livro (Imagem):</label>
            <input type="file" id="capa" name="capa" accept="image/*">
        </div>
        <button type="submit">Enviar Livro</button>
    </form>
<?php include('includes/footer.php'); ?>
