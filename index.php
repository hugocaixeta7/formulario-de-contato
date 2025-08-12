<?php 
session_start(); // Inicia ou retoma a sessão para armazenar dados do usuário entre páginas
?>

<!-- HTML -->
 <?php include('views/header.php'); ?>  <!-- Inclui a tudo linha a linha de outra página em outra pasta do projeto -->
<!-- BODY -->
<?php include('views/formMensagem.php'); ?> <!-- Inclui a tudo linha a linha de outra página em outra pasta do projeto -->
<!-- FOOTER -->
<script src="assets/script.js"></script> <!-- inclui o java script ai antes do body -->
</body>
</html>