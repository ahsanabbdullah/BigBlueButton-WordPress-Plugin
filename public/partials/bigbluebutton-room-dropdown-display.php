<div class="bbb-join-form-block bbb-room-selection-block">
    <label id="bbb-room-selection" class="bbb-join-room-label"><?php esc_html_e('Select Room', 'video-conferencing-with-bbb'); ?></label>
    <select aria-labelledby="bbb-room-selection" class="bbb-room-selection bbb-join-room-input">
        <?php foreach ( $rooms as $room ) { ?>
            <option id="<?php echo esc_attr( $room->room_id ); ?>" value="<?php echo esc_attr( $room->room_id ); ?>"
                <?php if ( $selected_room == $room->room_id ) { echo 'selected'; } ?>>
                <?php echo esc_html( $room->room_name ); ?>
            </option>
        <?php } ?>
    </select>
    <?php echo wp_kses_post( $html_form ); ?>
</div>