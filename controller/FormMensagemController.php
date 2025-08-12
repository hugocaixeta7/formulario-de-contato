<?php
session_start(); // Inicia ou retoma a sessão para armazenar dados do usuário entre páginas, aqui ele precisa ser executado pois ele tem que retomar e apresentar as validações na tela apos enviar o formulário.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   // Só executa o processamento se o formulário foi enviado via POST
    $errors = []; // Inicializa array para armazenar possíveis mensagens de erro da validação

    // Dados do formulário (com trim para remover espaços)
    $name = trim($_POST['name'] ?? '');         // Recebe o nome do formulário, removendo espaços extras e garantindo valor padrão vazio
    $email = trim($_POST['email'] ?? '');        // Recebe o email do formulário, removendo espaços extras e garantindo valor padrão vazio
    $subject = trim($_POST['subject'] ?? '');   // Recebe o assunto do formulário, removendo espaços extras e garantindo valor padrão vazio
    $content = trim($_POST['content'] ?? '');   // Recebe o conteúdo/mensagem do formulário, removendo espaços extras e garantindo valor padrão vazio


    // Validações específica por campo
    if (empty($name)) { // Verifica se a variável $name está vazia.
        $errors['name'] = 'O nome é obrigatório'; // Valida se o nome foi preenchido
    } elseif (strlen($name) < 2) {  // Se o nome não estiver vazio, verifica se o comprimento da string é menor que 2 caracteres, strlen() retorna o número de      caracteres na string.
        $errors['name'] = 'Nome deve ter pelo menos 2 caracteres'; // Valida se o nome tem pelo menos 2 caracteres
    }

    // Validação campo email
    if (empty($email)) { // Verifica se o campo email está vazio, ou seja, não foi preenchido pelo usuário.
        $errors['email'] = 'O email é obrigatório'; // Se estiver vazio, adiciona mensagem de erro para o campo 'email'.
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Caso o email não esteja vazio, usa a função filter_var() com o filtro FILTER_VALIDATE_EMAIL para validar se o formato do email é válido (ex: tem @, domínio, etc).
        $errors['email'] = 'Por favor, insira um email válido'; // se o formato for inválido, adiciona uma mensagem de erro.
    } elseif (strlen($email) > 255) { // Verifica se o email é muito longo (mais que 255 caracteres). Isso ajuda a evitar dados absurdos ou problemas no banco de dados.
        $errors['email'] = 'Email muito longo'; // Se o email ultrapassar o tamanho, adiciona uma mensagem de erro.
    }

    // validação campo assunto
    if (empty($subject)) { // Verifica se o campo sbject está vazio, ou seja, não foi preenchido pelo usuário.
        $errors['subject'] = 'O assunto é obrigatório'; // Se estiver vazio, retorna mensagem de erro para o campo 'email'.
    } elseif (strlen($subject) < 3) { // Verifica se o subject é muito curto. (menor que 3 caracteres)
        $errors['subject'] = 'Assunto deve ter pelo menos 3 caracteres'; //se for ele retorna a mesnagem de erro/aviso
    } elseif (strlen($subject) > 200) { // Aqui ele está verificando se o assunto é muito longo (+200 caracteres)
        $errors['subject'] = 'Assunto não pode ter mais de 200 caracteres'; // se for maior que 200 caracteres ele retorna a mensagem de erro/aviso
    }

    // validação campo mensagem
    if (empty($content)) { // verifica se o campo content está vazio, ou seja, não foi preenchido pelo usuário.
        $errors['content'] = 'A mensagem é obrigatória'; // se realmente estiver vazio ele retorna a mensagem de erro/aviso
    } elseif (strlen($content) < 10) { // verifica se o content é menor que 10 caracteres
        $errors['content'] = 'Mensagem deve ter pelo menos 10 caracteres'; // se realmente for menor ele retorna o aviso
    } elseif (strlen($content) > 1000) { // verifica se o conteudo é maior que 1000 caracteres
        $errors['content'] = 'Mensagem não pode ter mais de 1000 caracteres'; // se realmente for ele retorna o aviso, se as duas verificações retornar FALSE ele envia o formulario normalemnte em todos os casos acima 
    }

    // Se tem erros, salva na sessão
    if (!empty($errors)) { // Verifica se o array $errors não está vazio, ou seja, se há pelo menos um erro de validação.
        $_SESSION['form_errors'] = $errors; // Salva o array de erros na sessão, para que as mensagens possam ser exibidas na próxima requisição (normalmente no formulário). 
        $_SESSION['form_data'] = $_POST; // Salva os dados enviados no formulário na sessão para manter os valores preenchidos pelo usuário, evitando que ele tenha que digitar tudo de novo.
        $_SESSION['error_message'] = 'Por favor, preencha todos os campos abaixo'; // Define uma mensagem genérica de erro para ser exibida na interface, avisando que há campos com problemas.
    } else { // Caso não haja erros, o processamento segue para o próximo passo (geralmente salvar dados, enviar email, etc).

        try { // Inicia um bloco que vai tentar executar o código e capturar erros/exceções que podem ocorrer durante o processo (como falha no banco ou no envio do email).

            require_once('../models/saveFormModel.php');  // Importa o arquivo que contém a função saveForm, responsável por salvar os dados no banco.
            // garante que o arquivo seja incluído apenas uma vez, evitando erros.

            $result = saveForm($name, $email, $subject, $content); // Chama a função saveForm, passando os dados do formulário para salvar no banco.
            // O resultado da função (normalmente booleano ou id inserido) é armazenado em $result.

            $dados = [ // Cria um array associativo com os dados do formulário para usar depois, por exemplo, para enviar email ou mostrar na confirmação.
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'content' => $content
            ];
            require_once('../lib/phpMailer.php'); // Importa a biblioteca ou script para envio de email (PHPMailer), preparando para enviar uma notificação ou confirmação.

            if ($result) { // Verifica se o resultado do saveForm foi bem sucedido (normalmente true ou ID da inserção).
                $_SESSION['success_message'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.'; // Define uma mensagem de sucesso na sessão para ser exibida na próxima página.
                unset($_SESSION['form_errors'], $_SESSION['form_data'], $_SESSION['error_message']); // Limpa as mensagens de erro e os dados do formulário da sessão, já que o envio foi concluído com sucesso.
            } else {
                throw new Exception('Erro interno do servidor. Tente novamente.'); // Caso $result seja falso ou inválido, lança uma exceção com mensagem de erro genérica.
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro ao enviar mensagem: ' . $e->getMessage(); // Captura qualquer exceção lançada dentro do bloco try e salva a mensagem de erro na sessão para exibição.
        }
    }

    header('Location: ../index.php'); // Redireciona o usuário para a página inicial (ou formulário) após o processamento, interrompendo a execução do script.
    exit(); // Redireciona sempre para a página inicial após processamento

} else {
    // Se a requisição não for POST, redireciona para evitar acesso direto indevido
    header('Location: ../index.php');
    exit();
}
