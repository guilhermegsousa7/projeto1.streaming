<?php
// Arquivo: admin/processar_upload.php
require_once 'config.inc.php';

if (isset($_POST['submit'])) {
    
    // 1. Informações do Formulário
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);

    // 2. Informações do Arquivo
    $video_file = $_FILES['video_file']; // Array com infos do arquivo

    // Verifica se houve erro no upload
    if ($video_file['error'] !== UPLOAD_ERR_OK) {
        header('Location: upload_video.php?error=1&msg=' . urlencode('Erro no upload do arquivo. Código: ' . $video_file['error']));
        exit();
    }
    
    $file_name = $video_file['name'];
    $file_tmp_name = $video_file['tmp_name']; // Localização temporária
    $file_size = $video_file['size'];
    $file_type = $video_file['type'];

    // 3. Validação Simples
    $allowed_types = ['video/mp4', 'video/webm'];
    if (!in_array($file_type, $allowed_types)) {
        header('Location: upload_video.php?error=1&msg=' . urlencode('Formato de arquivo não permitido. Apenas MP4 e WEBM.'));
        exit();
    }

    // Limite de tamanho (ex: 100MB) - Cuidado com o limite do seu php.ini (upload_max_filesize)
    $max_size = 100 * 1024 * 1024; // 100 MB
    if ($file_size > $max_size) {
        header('Location: upload_video.php?error=1&msg=' . urlencode('Arquivo muito grande. Limite de 100MB.'));
        exit();
    }

    // 4. Mover o Arquivo para o Destino Final
    
    // Gera um nome único para evitar sobrescrever arquivos com o mesmo nome
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = uniqid('video_', true) . '.' . $file_extension;
    
    // O caminho de destino. __DIR__ é a pasta atual (admin), '..' volta um nível
    $upload_dir = __DIR__ . '/../uploads/'; 
    $destination_path = $upload_dir . $new_file_name;

    // O caminho a ser salvo no DB (relativo à raiz do site, não ao PHP)
    $db_path = '../uploads/' . $new_file_name; // Ajuste se a pasta /uploads/ estiver em outro local

    if (move_uploaded_file($file_tmp_name, $destination_path)) {
        // 5. Salvar no Banco de Dados
        try {
            $stmt = $pdo->prepare("INSERT INTO videos (titulo, descricao, nome_arquivo, caminho_arquivo) VALUES (:titulo, :descricao, :nome, :caminho)");
            $stmt->execute([
                ':titulo' => $titulo,
                ':descricao' => $descricao,
                ':nome' => $new_file_name,
                ':caminho' => $db_path
            ]);
            
            header('Location: upload_video.php?msg=' . urlencode('Vídeo enviado com sucesso!'));
            exit();

        } catch (PDOException $e) {
            // Se falhar o DB, deleta o arquivo que foi salvo
            unlink($destination_path); 
            header('Location: upload_video.php?error=1&msg=' . urlencode('Erro ao salvar no banco de dados: ' . $e->getMessage()));
            exit();
        }
    } else {
        header('Location: upload_video.php?error=1&msg=' . urlencode('Erro ao mover o arquivo para o destino. Verifique as permissões da pasta uploads.'));
        exit();
    }
} else {
    // Redireciona se alguém acessar o script diretamente
    header('Location: upload_video.php');
    exit();
}
?>
