<?php
global $message, $trace;
(is_string($message) && ! empty($message)) or $message = 'Unknown Error.';
is_string($trace) or $trace = '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"><title>Error</title>
    </head>
    <body style="margin: 30px;">
        <h1>Error</h1>
        <p><?= htmlentities($message, ENT_QUOTES|ENT_HTML5, 'UTF-8') ?></p>
        <?php if ($trace) : ?>
        <p>
            Stacktrace:
            <pre><?= htmlentities($trace, ENT_QUOTES|ENT_HTML5, 'UTF-8') ?></pre>
         </p>
        <?php endif ?>
    </body>
</html>
