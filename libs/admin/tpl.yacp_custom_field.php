<?php
/**
 * This file must be included into the YacpPostType Class. If not, it'll break the moon and kill
 * Everybody around the server ... :'(
 */
?>

<div class="yacp_settings">
    <div class="form-row">
        <label for="yacp_theme">
            <?php echo $this->custom_fields['theme']['name']; ?>
        </label>
        <select name="yacp_theme" id="yacp_theme" width="120">
            <?php foreach ($this->available_themes as $key => $value) : ?>
                <option value="<?php echo $key ?>" <?php if ($ctx['theme'] == $key) echo 'selected'; ?>>
                    <?php echo $value ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>