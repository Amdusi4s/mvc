<?php

$routes = [];

foreach (scandir(__DIR__ . '/routes') AS $fileName) {
    if ($fileName !== '.' && $fileName !== '..') {
        require __DIR__ . '/routes/' . $fileName;
    }
}