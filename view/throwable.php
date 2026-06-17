<?php

declare(strict_types=1);

/** @var Throwable $throwable */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Internal Server Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main>
    <h1>500 Error</h1>
    <p><?= $throwable->getMessage(); ?></p>
    <p><a href="/">To site</a></p>
</main>
</body>
</html>
