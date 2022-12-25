<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = ($message);
}
?>
<div class="alert alert-warning" onclick="this.classList.add('hidden');"><?= $message ?></div>