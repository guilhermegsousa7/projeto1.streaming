<?php
// Arquivo: admin/assistir.php
require_once 'config.inc.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: listar_videos.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $video = $stmt->fetch();

    if (!$video) {
        die("Vídeo não encontrado.");
    }

} catch (PDOException $e) {
    die("Erro ao buscar o vídeo: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Assistindo: <?php echo htmlspecialchars($video['titulo']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .video-player-container {
            max-width: 900px;
            margin: 20px auto;
            background: #000;
        }
        video {
            width: 100%;
            height: auto;
        }
        .video-info {
            max-width: 900px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <p><a href="listar_videos.php">← Voltar para a Galeria</a></p>
    
    <div class="video-player-container">
        <video controls autoplay>
            <source src="<?php echo htmlspecialchars($video['caminho_arquivo']); ?>" type="video/mp4">
            Seu navegador não suporta a tag de vídeo.
        </video>
    </div>

    <div class="video-info">
        <h1><?php echo htmlspecialchars($video['titulo']); ?></h1>
        <p><strong>Enviado em:</strong> <?php echo date('d/m/Y H:i', strtotime($video['data_upload'])); ?></p>
        <hr>
        <p><?php echo nl2br(htmlspecialchars($video['descricao'])); ?></p>
    </div>

</body>
</html>
