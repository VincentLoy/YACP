<?php
/**
 * This file must be included into the YacpPostType Class. If not, it'll break the moon and kill
 * Everybody around the server ... :'(
 */
?>

<div class="yacp_settings">
    <div class="form-row">
        <label for="yacp_theme">
            <?php _e('Theme', 'yacp_textdomain'); ?>
        </label>
        <select name="yacp_theme" id="yacp_theme">
            <?php foreach ($this->available_themes as $key => $value) : ?>
                <option value="<?php echo $key ?>" <?php if ($theme == $key) echo 'selected'; ?>>
                    <?php echo $value ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>