<?php
session_start();
include('includes/db.php');

$mensagem = '';

// Verifica se há uma mensagem de redirecionamento na sessão
if (isset($_SESSION['mensagem_login'])) {
    $mensagem = $_SESSION['mensagem_login'];
    unset($_SESSION['mensagem_login']); // Remove a mensagem da sessão após exibi-la
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $u = $result->fetch_assoc();
        if (password_verify($senha, $u['senha'])) {
            $_SESSION['usuario_id'] = $u['id'];
            $_SESSION['usuario_nome'] = $u['nome'];
            // Redirecionamento inteligente
            if (isset($_SESSION['redirect'])) {
                $destino = $_SESSION['redirect'];
                unset($_SESSION['redirect']);
                header("Location: $destino");
            } else {
                header('Location: livros_lista.php');
            }
            exit;
        } else {
            $mensagem = "<div class='mensagem error'><p>Email ou senha inválidos.</p></div>";
        }
    } else {
        $mensagem = "<div class='mensagem error'><p>Email ou senha inválidos.</p></div>";
    }
    $stmt->close();
}
$conn->close();

include('includes/header.php');
?>
    <h1 style="text-align: center; margin-top: 20px;">Login de Usuário</h1>
    <?php echo $mensagem; // Exibe a mensagem, se houver ?>

    <form method="post">
        <h2>Acesse sua conta BIBLYOS</h2>
        <input name="email" type="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
        <input name="senha" type="password" placeholder="Senha" required><br>
        <button type="submit">Entrar</button>
        <p style="text-align: center; margin-top: 15px;">Não tem uma conta? <a href="cadastro.php" style="background: none; color: #007bff; padding: 0; text-decoration: underline; font-weight: normal;">Cadastre-se aqui</a></p>
    </form>
<?php include('includes/footer.php'); ?>
