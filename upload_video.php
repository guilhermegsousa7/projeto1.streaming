<?php
// Arquivo: admin/upload_video.php
require_once 'config.inc.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Enviar Novo Vídeo</title>
    <link rel="stylesheet" href="../css/style.css"> </head>
<body>
    <h1>Enviar Novo Vídeo</h1>
    <p><a href="listar_videos.php">Ver Galeria de Vídeos</a></p>

    <?php if (isset($_GET['msg'])): ?>
        <div class="message <?php echo (isset($_GET['error']) ? 'error' : 'success'); ?>">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <form action="processar_upload.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="titulo">Título do Vídeo:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>
        <div>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"></textarea>
        </div>
        <div>
            <label for="video_file">Arquivo de Vídeo (MP4, WEBM):</label>
            <input type="file" id="video_file" name="video_file" accept="video/mp4,video/webm" required>
        </div>
        <button type="submit" name="submit">Enviar Vídeo</button>
    </form>
</body>
</html>
