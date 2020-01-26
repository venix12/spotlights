<?php

function format_date(string $date, bool $hour = false)
{
    $formatted = substr($date, 0, $hour ? -3 : -9);

    return $formatted;
}
