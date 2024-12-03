<?php

function active_class($path, $active = 'active') {
    return Request::is($path . '*') ? $active : '';
}

function is_active_route($path) {
    return Request::is($path . '*') ? 'true' : 'false';
}

function show_class($path) {
    return Request::is($path . '*') ? 'show' : '';
}
