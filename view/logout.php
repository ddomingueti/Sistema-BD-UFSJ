<?php

session_start();

unset($_SESSION['cpf']);
unset($_SESSION['tipo_usuario']);

header('location: ../index.php');
