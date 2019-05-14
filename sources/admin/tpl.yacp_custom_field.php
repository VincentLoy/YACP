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

        <?php
        if (!empty($ctx['date'])) {
            $attr = 'value="' . $ctx['date'] . '"';
        } else {
            $attr = '';
        }
        ?>
        <input type="datetime" id="yacp_date" name="yacp_date"
            <?php echo $attr; ?> class="yacp_date">
    </div>
    <div class="form-block utc">
        <label for="yacp_utc">
            <?php echo $this->custom_fields['utc']['name']; ?>
        </label>

        <?php
        if (!empty($ctx['utc'])) {
            $attr = 'checked';
        } else {
            $attr = '';
        }
        ?>
        <input type="checkbox" name="yacp_utc"
               id="yacp_utc" <?php echo $attr; ?> class="yacp_utc">
    </div>
    <div class="form-block zero_pad">
        <label for="yacp_zero_pad">
            <?php echo $this->custom_fields['zero_pad']['name']; ?>
        </label>
        <?php
        if (!empty($ctx['zero_pad'])) {
            $attr = 'checked';
        } else {
            $attr = '';
        }
        ?>
        <input type="checkbox" name="yacp_zero_pad" id="yacp_zero_pad"
            <?php echo $attr; ?> class="yacp_zero_pad">
    </div>

    <div class="form-block count_up">
        <label for="yacp_count_up">
            <?php echo $this->custom_fields['count_up']['name']; ?>
        </label>

        <?php
        if (!empty($ctx['count_up'])) {
            $attr = 'checked';
        } else {
            $attr = '';
        }
        ?>
        <input type="checkbox" name="yacp_count_up" id="yacp_count_up"
            <?php echo $attr; ?> class="yacp_zero_pad">
    </div>

    <div class="form-block">
        <label for="yacp_theme">
            <?php echo $this->custom_fields['theme']['name']; ?>
        </label>
        <select name="yacp_theme" id="yacp_theme" width="120">
            <?php foreach ($this->available_themes as $key => $value) : ?>
                <?php
                if ($ctx['theme'] == $key) {
                    $attr = 'selected';
                } else {
                    $attr = '';
                }
                ?>
                <option value="<?php echo $key ?>" <?php echo $attr; ?>>
                    <?php echo $value ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="yacp_settings">
    <div class="form-block">
        <label for="yacp_days">
            <?php echo $this->custom_fields['days']['name']; ?>
        </label>

        <?php
        if (empty($ctx['days'])) {
            $attr = 'value="day"';
        } else {
            $attr = 'value="' . $ctx['days'] . '"';
        }
        ?>
        <input type="text" name="yacp_days" class="yacp_days" id="yacp_days"
            <?php echo $attr; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_hours">
            <?php echo $this->custom_fields['hours']['name']; ?>
        </label>

        <?php
        if (empty($ctx['hours'])) {
            $attr = 'value="hour"';
        } else {
            $attr = 'value="' . $ctx['hours'] . '"';
        }
        ?>
        <input type="text" name="yacp_hours" class="yacp_hours" id="yacp_hours"
            <?php echo $attr; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_minutes">
            <?php echo $this->custom_fields['minutes']['name']; ?>
        </label>

        <?php
        if (empty($ctx['minutes'])) {
            $attr = 'value="minute"';
        } else {
            $attr = 'value="' . $ctx['minutes'] . '"';
        }
        ?>
        <input type="text" name="yacp_minutes" class="yacp_minutes" id="yacp_minutes"
            <?php echo $attr; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_seconds">
            <?php echo $this->custom_fields['seconds']['name']; ?>
        </label>

        <?php
        if (empty($ctx['seconds'])) {
            $attr = 'value="second"';
        } else {
            $attr = 'value="' . $ctx['seconds'] . '"';
        }
        ?>
        <input type="text" name="yacp_seconds" class="yacp_seconds" id="yacp_seconds"
            <?php echo $attr; ?>>
    </div>
    <div class="form-block">
        <label for="yacp_plural_letter">
            <?php echo $this->custom_fields['plural_letter']['name']; ?>
        </label>

        <?php
        if (empty($ctx['plural_letter'])) {
            $attr = 'value="s"';
        } else {
            $attr = 'value="' . $ctx['plural_letter'] . '"';
        }
        ?>
        <input type="text" name="yacp_plural_letter" class="yacp_plural_letter"
               id="yacp_plural_letter"
            <?php echo $attr; ?>>
    </div>
</div>