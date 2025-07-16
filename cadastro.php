<?php
session_start();
include('includes/db.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha) || empty($confirma_senha)) {
        $mensagem = "<div class='mensagem error'><p>Por favor, preencha todos os campos.</p></div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "<div class='mensagem error'><p>Formato de email inválido.</p></div>";
    } elseif ($senha !== $confirma_senha) {
        $mensagem = "<div class='mensagem error'><p>As senhas não coincidem.</p></div>";
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensagem = "<div class='mensagem error'><p>Este email já está cadastrado. Por favor, tente outro.</p></div>";
        } else {
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senha_hashed);

            if ($stmt->execute()) {
                $mensagem = "<div class='mensagem success'><p>Cadastro realizado com sucesso! Você já pode <a href='login.php' style='background: none; color: #155724; padding: 0; text-decoration: underline; font-weight: bold;'>fazer login</a>.</p></div>";
            } else {
                $mensagem = "<div class='mensagem error'><p>Erro ao cadastrar: " . $conn->error . "</p></div>";
            }
        }
        $stmt->close();
    }
}
$conn->close();

include('includes/header.php');
?>
    <h1 style="text-align: center; margin-top: 20px;">Cadastro de Usuário</h1>
    <?php echo $mensagem; ?>

    <form method="post">
        <h2>Crie sua conta BIBLYOS</h2>
        <input name="nome" type="text" placeholder="Nome Completo" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"><br>
        <input name="email" type="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
        <input name="senha" type="password" placeholder="Senha" required><br>
        <input name="confirma_senha" type="password" placeholder="Confirme a Senha" required><br>
        <button type="submit">Cadastrar</button>
        <p style="text-align: center; margin-top: 15px;">Já tem uma conta? <a href="login.php" style="background: none; color: #007bff; padding: 0; text-decoration: underline; font-weight: normal;">Faça Login aqui</a></p>
    </form>
<?php include('includes/footer.php'); ?>
