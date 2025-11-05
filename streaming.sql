-- Arquivo: streaming.sql
-- Use o banco de dados existente ou crie um novo.
-- USE projeto_crud;

CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    nome_arquivo VARCHAR(255) NOT NULL, -- O nome do arquivo (ex: video_123.mp4)
    caminho_arquivo VARCHAR(512) NOT NULL, -- O caminho no servidor (ex: uploads/video_123.mp4)
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP
