<?php
$errors = $_SESSION['form_errors'] ?? []; // Recupera os erros do formulário salvos na sessão ou usa array vazio se não houver erros
$dados = $_SESSION['form_data'] ?? []; 
?>

<body>
<div class="form-container">
    <!-- Cabeçalho -->
    <div class="form-header">
        <h1 class="form-title">Fale Conosco</h1>
        <p class="form-subtitle">Envie sua mensagem de forma rápida e intuitiva</p>
    </div>

    <!-- Barra de Progresso -->
    <div class="progress-bar">
        <div class="progress-fill" id="progressFill" style="width: 0%"></div>
    </div>

    <!-- Mensagens Globais -->
     <?php if (isset($_SESSION['success_message'])): ?> <!-- Verifica se existe uma mensagem de sucesso na sessão para exibir ao usuário -->
                                                    <!-- A superglobal $_SESSION é criada automaticamente pelo PHP quando é chamado session_start(); em algum lugar -->
                                                     <!-- 'success_message' Foi criada e está sendo chamada da controller -->
        <div class="success-message">
            <div class="message-icon">✅</div>
            <div class="message-text"><?= $_SESSION['success_message'] ?></div>  <!-- Exibe a mensagem de sucesso armazenada na sessão dentro de uma div -->
        </div>
        <?php unset($_SESSION['success_message']); ?> <!-- Remove a mensagem de sucesso da sessão após exibi-la, evitando que apareça novamente -->
    <?php endif; ?> <!-- Fim do if -->

    <?php if (isset($_SESSION['error_message'])): ?> <!-- Verifica se existe uma mensagem de erro na sessão -->
        <div class="error-message">
            <div class="message-icon">❌</div>
            <div class="message-text"><?= $_SESSION['error_message'] ?></div> <!-- Exibe a mensagem de erro ao usuário -->
        </div>
        <?php unset($_SESSION['error_message']); ?> <!-- Remove a mensagem de erro da sessão após exibição -->
    <?php endif; ?> <!-- Fim do bloco if -->

    <!-- Formulário -->
    <form action="controller/FormMensagemController.php" method="POST" id="contactForm" novalidate> <!-- Formulário que envia os dados para o controlador PHP via POST. A validação HTML5 foi desativada (novalidate). -->
        
        <!-- Campo Nome -->
        <div class="form-group">
            <label for="name" class="form-label">
                Nome Completo *
                <?php if (isset($errors['name'])): ?>   
                    <span class="label-error">(<?= $errors['name'] ?>)</span> <!-- Exibe erro ao lado do label, se existir -->
                <?php endif; ?>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                required
                class="form-input <?= isset($errors['name']) ? 'input-error' : '' ?>"  
                placeholder="Digite seu nome completo"
                value="<?= htmlspecialchars($dados['name'] ?? '') ?>" 
                maxlength="100">
                <!-- Na linha 54 ele Adiciona classe de erro se houver problema  -->
                 <!-- Já na linha 56 Mantém o valor digitado pelo usuário para não perder dados -->
            <?php if (isset($errors['name'])): ?>
                <div class="field-error">
                    <span class="error-icon">⚠️</span>
                    <?= $errors['name'] ?> <!-- Mensagem de erro exibida abaixo do campo -->
                </div>
            <?php endif; ?>
                                            <!-- A mema logica de validação acontece para todos os campos abaixo presentes no formulário -->
        </div>

        <!-- Campo Email -->
        <div class="form-group">
            <label for="email" class="form-label">
                Email *
                <?php if (isset($errors['email'])): ?>
                    <span class="label-error">(<?= $errors['email'] ?>)</span>
                <?php endif; ?>
            </label>
            <input
                type="email"
                id="email"
                name="email"
                required
                class="form-input <?= isset($errors['email']) ? 'input-error' : '' ?>"
                placeholder="seu@email.com"
                value="<?= htmlspecialchars($dados['email'] ?? '') ?>"
                maxlength="255">
            <?php if (isset($errors['email'])): ?>
                <div class="field-error">
                    <span class="error-icon">⚠️</span>
                    <?= $errors['email'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Campo Assunto -->
        <div class="form-group">
            <label for="subject" class="form-label">
                Assunto *
                <?php if (isset($errors['subject'])): ?>
                    <span class="label-error">(<?= $errors['subject'] ?>)</span>
                <?php endif; ?>
            </label>
            <input
                type="text"
                id="subject"
                name="subject"
                required
                class="form-input <?= isset($errors['subject']) ? 'input-error' : '' ?>"
                placeholder="Assunto da sua mensagem"
                value="<?= htmlspecialchars($dados['subject'] ?? '') ?>"
                maxlength="200">
            <?php if (isset($errors['subject'])): ?>
                <div class="field-error">
                    <span class="error-icon">⚠️</span>
                    <?= $errors['subject'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Campo Mensagem -->
        <div class="form-group">
            <label for="content" class="form-label">
                Mensagem *
                <?php if (isset($errors['content'])): ?>
                    <span class="label-error">(<?= $errors['content'] ?>)</span>
                <?php endif; ?>
            </label>
            <textarea
                id="content"
                name="content"
                required
                class="form-textarea <?= isset($errors['content']) ? 'input-error' : '' ?>"
                placeholder="Digite sua mensagem aqui..."
                maxlength="1000"><?= htmlspecialchars($dados['content'] ?? '') ?></textarea>
            <div class="char-counter">
                <span id="charCount">0</span>/1000 caracteres
            </div>
            <?php if (isset($errors['content'])): ?>
                <div class="field-error">
                    <span class="error-icon">⚠️</span>
                    <?= $errors['content'] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botão de envio -->
        <button type="submit" name="SendAddMsg" class="form-button" id="submitBtn">
            <span id="buttonText">📤 Enviar Mensagem</span>
        </button>
    </form>
</div>

<?php
// Limpa os dados da sessão após exibir
unset($_SESSION['form_errors'], $_SESSION['form_data']); // Remove os erros e dados do formulário da sessão após o processamento
?>
