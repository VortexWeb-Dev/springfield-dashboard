<?php

// Add resuable utility functions here

// calculate duration in months
function duration_months($date)
{
    $date1 = new DateTime($date);
    $date2 = new DateTime();
    $interval = $date1->diff($date2);
    return $interval->m + ($interval->y * 12);
}

// map enum with the values
function map_enum($fields, $field_id, $key_to_map)
{
    foreach ($fields as $field) {
        if (isset($field['title']) && $field['title'] == $field_id) {
            foreach ($field['items'] as $item) {
                if ($item['ID'] == $key_to_map) {
                    return $item['VALUE'];
                }
            }
        }
    }
}
