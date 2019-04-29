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
            <input type="datetime" id="yacp_date" name="yacp_date"
                <?php if (!empty($ctx['date'])) echo 'value="' . $ctx['date'] . '"'; ?> class="yacp_date">
        </div>
        <div class="form-block utc">
            <label for="yacp_utc">
                <?php echo $this->custom_fields['utc']['name']; ?>
            </label>
            <input type="checkbox" name="yacp_utc" id="yacp_utc" <?php if (!empty($ctx['utc'])) echo 'checked'; ?>
                class="yacp_utc">
        </div>
        <div class="form-block zero_pad">
            <label for="yacp_zero_pad">
                <?php echo $this->custom_fields['zero_pad']['name']; ?>
            </label>
            <input type="checkbox" name="yacp_zero_pad" id="yacp_zero_pad"
                <?php if (!empty($ctx['zero_pad'])) echo 'checked'; ?> class="yacp_zero_pad">
        </div>

        <div class="form-block count_up">
            <label for="yacp_count_up">
                <?php echo $this->custom_fields['count_up']['name']; ?>
            </label>
            <input type="checkbox" name="yacp_count_up" id="yacp_count_up"
                <?php if (!empty($ctx['count_up'])) echo 'checked'; ?> class="yacp_zero_pad">
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


    <!-- days
hours
minutes
seconds
plural_letter -->
</div>

<div class="yacp_settings">
    <div class="form-block">
        <label for="yacp_days">
            <?php echo $this->custom_fields['days']['name']; ?>
        </label>
        <input type="text" name="yacp_days" class="yacp_days" id="yacp_days"
            <?php if (empty($ctx['days'])) echo 'value="day"'; else echo 'value="' . $ctx['days'] . '"'; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_hours">
            <?php echo $this->custom_fields['hours']['name']; ?>
        </label>
        <input type="text" name="yacp_hours" class="yacp_hours" id="yacp_hours"
            <?php if (empty($ctx['hours'])) echo 'value="hour"'; else echo 'value="' . $ctx['hours'] . '"'; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_minutes">
            <?php echo $this->custom_fields['minutes']['name']; ?>
        </label>
        <input type="text" name="yacp_minutes" class="yacp_minutes" id="yacp_minutes"
            <?php if (empty($ctx['minutes'])) echo 'value="minute"'; else echo 'value="' . $ctx['minutes'] . '"'; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_seconds">
            <?php echo $this->custom_fields['seconds']['name']; ?>
        </label>
        <input type="text" name="yacp_seconds" class="yacp_seconds" id="yacp_seconds"
            <?php if (empty($ctx['seconds'])) echo 'value="second"'; else echo 'value="' . $ctx['seconds'] . '"'; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_plural_letter">
            <?php echo $this->custom_fields['plural_letter']['name']; ?>
        </label>
        <input type="text" name="yacp_plural_letter" class="yacp_plural_letter" id="yacp_plural_letter"
            <?php if (empty($ctx['plural_letter'])) echo 'value="s"'; else echo 'value="' . $ctx['plural_letter'] . '"'; ?>>
    </div>
</div>