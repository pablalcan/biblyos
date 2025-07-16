<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(slogan);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/estilo.css" />
    <title>BIBLYOS - Sua Biblioteca Digital</title>
</head>
<body>

    <footer style="text-align: center; padding: 25px; margin-top: 40px; border-top: 1px solid #eee; color: #777; font-size: 0.9em; background: #f9f9f9; border-radius: 0 0 8px 8px; box-shadow: 0 -2px 5px rgba(0,0,0,0.05);">

        <!-- Seção de Doação via Pix -->
        <div style="margin-top: 30px;">
            <h2 style="margin-bottom: 10px;">Ajude a manter a BIBLYOS no ar!</h2>
            <p style="margin-bottom: 15px;">Sua doação nos ajuda a manter o site funcionando gratuitamente para todos.</p>

            <button id="btnDoarPix" style="padding: 10px 20px; font-size: 1em; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Fazer uma Doação via Pix
            </button>

            <div id="pixInfo" style="display: none; margin-top: 20px;">
                <p><strong>Chave Pix:</strong> <span style="color: green;">doacoes@biblyos.com</span></p>
                <p>Escaneie o QR Code com seu app de banco:</p>
                <img src="/biblioteca_digital_BIBLYOS/uploads/imagens/qrcode.jpg" alt="QR Code Pix" style="max-width: 200px; border: 1px solid #ccc; padding: 5px; border-radius: 8px;" />
                <p style="margin-top: 10px; font-size: 0.9em; color: #666;">Você escolhe o valor! Qualquer quantia ajuda ❤️</p>
            </div> 
        </div>
<br> 
<p>&copy; <?= date('Y') ?> BIBLYOS. Todos os direitos reservados.</p>

    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const botao = document.getElementById('btnDoarPix');
            const infoPix = document.getElementById('pixInfo');

            if (botao && infoPix) {
                botao.addEventListener('click', function () {
                    if (infoPix.style.display === 'none' || infoPix.style.display === '') {
                        infoPix.style.display = 'block';
                        botao.textContent = 'Ocultar Informações do Pix';
                    } else {
                        infoPix.style.display = 'none';
                        botao.textContent = 'Fazer uma Doação via Pix';
                    }
                });
            }
        });
    </script>
</body>
</html>