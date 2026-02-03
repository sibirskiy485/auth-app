<?php

function redirect(string $path): void
{
    header('Location: /?page=' . urlencode($path), true, 303);
    exit;
}

function clean(string $value): string
{
    return trim(htmlspecialchars($value));
}