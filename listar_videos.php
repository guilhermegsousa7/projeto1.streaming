<?php
// Arquivo: admin/listar_videos.php
require_once 'config.inc.php';

try {
    $stmt = $pdo->query("SELECT * FROM videos ORDER BY data_upload DESC");
    $videos = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erro ao buscar vídeos: " . $e->getMessage();
    $videos = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Galeria de Vídeos</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .video-gallery { display: flex; flex-wrap: wrap; gap: 20px; }
        .video-card { width: 300px; border: 1px solid #ccc; border-radius: 8px; padding: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .video-card h3 { margin-top: 0; }
        .video-card a { text-decoration: none; color: #007bff; }
        .video-thumbnail { background-color: #000; color: white; height: 150px; display: flex; align-items: center; justify-content: center; border-radius: 4px; font-size: 24px; }
    </style>
</head>
<body>
    <h1>Galeria de Vídeos</h1>
    <p><a href="upload_video.php">Enviar Novo Vídeo</a></p>
    <hr>
    
    <div class="video-gallery">
        <?php if (count($videos) > 0): ?>
            <?php foreach ($videos as $video): ?>
                <div class="video-card">
                    <a href="assistir.php?id=<?php echo $video['id']; ?>">
                        <div class="video-thumbnail">▶</div>
                    </a>
                    <h3>
                        <a href="assistir.php?id=<?php echo $video['id']; ?>">
                            <?php echo htmlspecialchars($video['titulo']); ?>
                        </a>
                    </h3>
                    <p><?php echo htmlspecialchars(substr($video['descricao'], 0, 100)) . '...'; ?></p>
                    <small>Enviado em: <?php echo date('d/m/Y', strtotime($video['data_upload'])); ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum vídeo enviado ainda.</p>
        <?php endif; ?>
    </div>

</body>
</html>
