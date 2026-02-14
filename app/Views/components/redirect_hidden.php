<?php $redirectValue = get_redirect_value($redirect ?? null); ?>
<input type="hidden" name="redirect" value="<?= esc($redirectValue) ?>">
