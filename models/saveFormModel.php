<?php
require_once ('database/conn.php'); // Importa o arquivo que estabelece a conexão com o banco de dados

function saveForm($name, $email, $subject, $content) {  // Função que recebe os dados do formulário e salva uma mensagem no banco de dados
    global $conn; // Usa a variável global $conn que contém a conexão PDO com o banco

    // Query SQL para inserir uma nova mensagem na tabela contacts_msgs, usando placeholders nomeados
    //basicamente a query (pergunta ou consulta) ao banco de dados abaixo 
    $query_msg = "INSERT INTO contacts_msgs    
                    (name, email, subject, content, created)
                  VALUES (:name, :email, :subject, :content, NOW())";

    $cad_msg = $conn->prepare($query_msg); // Prepara a query para execução segura contra SQL Injection
    $cad_msg->bindParam(':name', $name, PDO::PARAM_STR); // Associa o valor de $name ao placeholder :name como string
    $cad_msg->bindParam(':email', $email, PDO::PARAM_STR); // Associa o valor de $email ao placeholder :email
    $cad_msg->bindParam(':subject', $subject, PDO::PARAM_STR); // Associa o valor de $subject ao placeholder :subject
    $cad_msg->bindParam(':content', $content, PDO::PARAM_STR); // Associa o valor de $content ao placeholder :content

    return $cad_msg->execute(); // Executa a query e retorna true se inserção der certo, ou false se falhar
}

