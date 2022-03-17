<?php

function format_phone_number(string $phone): ?string
{
    if (preg_match('/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/', $phone, $matches)) {
        return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
    }

    return null;
}