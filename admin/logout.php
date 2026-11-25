<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/auth.php';

logout();
header('Location: ../index.php');
exit;
