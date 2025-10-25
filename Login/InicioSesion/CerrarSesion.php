<?php

 session_start();
 session_destroy();
 header('Location: /Restaurante/index.php');
 exit;
