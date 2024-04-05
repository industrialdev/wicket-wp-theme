<?php

// https://docs.theeventscalendar.com/reference/files/src/tribe/attendee/registration/iac.php/
// Adjust label for Name field to be Full Name. We'd then typically add First and Last Name fields as well
add_filter( 'tribe_tickets_plus_attendee_registration_iac_fields', 'tec_custom_field_label', 10, 3 );

function tec_custom_field_label( $fields, $ticket_iac_setting, $ticket_id ) {
	ksort($fields);
	$fields['name']['label'] = __('First Name', 'wicket');

	return $fields;
}
