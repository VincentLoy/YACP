<?php
/**
 * This file must be included into the YacpPostType Class. If not, it'll break the moon and kill
 * Everybody around the server ... :'(
 */
?>

<div class="yacp_shortcode_preview">
    <input type="text"
           onClick="this.setSelectionRange(0, this.value.length)"
           value="<?php echo htmlentities($shortcode, ENT_QUOTES); ?>"
           style="width: 100%;"
           readonly>
</div>