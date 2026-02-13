<?php
$redirectValue = old('redirect');
if ($redirectValue === null) {
  $redirectValue = $redirect ?? '';
}

$redirectValue = sanitize_redirect($redirectValue) ?? '';
?>
<input type="hidden" name="redirect" value="<?= esc($redirectValue) ?>">
