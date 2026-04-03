<?php
session_start();
// Détruire la session
session_destroy();
header("Location: login.php");
exit;