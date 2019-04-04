<?php
/**
 * This file must be included into the YacpPostType Class. If not, it'll break the moon and kill
 * Everybody around the server ... :'(
 */
?>

<div class="yacp_settings">
    <div class="form-block date-picker">
        <label for="yacp_date">
            <?php echo $this->custom_fields['date']['name']; ?>
        </label>
        <input type="datetime"
               id="yacp_date"
               name="yacp_date"
                <?php if (!empty($ctx['date'])) echo 'value="' . $ctx['date'] . '"'; ?>
               class="yacp_date">
    </div>
    <div class="form-block utc">
        <label for="yacp_utc">
            <?php echo $this->custom_fields['utc']['name']; ?>
        </label>
        <input type="checkbox"
               name="yacp_utc"
               id="yacp_utc"
                <?php if (!empty($ctx['utc'])) echo 'checked'; ?>
               class="yacp_utc">
    </div>
    <div class="form-block zero_pad">
        <label for="yacp_zero_pad">
            <?php echo $this->custom_fields['zero_pad']['name']; ?>
        </label>
        <input type="checkbox"
               name="yacp_zero_pad"
               id="yacp_zero_pad"
                <?php if (!empty($ctx['zero_pad'])) echo 'checked'; ?>
               class="yacp_zero_pad">
    </div>
    <div class="form-block">
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
