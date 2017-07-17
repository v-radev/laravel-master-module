<?php

if (! function_exists('input_class')) {
    function input_class($inputName, $errors, $extraClass = '')
    {
        return $errors->has($inputName) ? "form-control error {$extraClass}" : "form-control {$extraClass}";
    }
}

if (! function_exists('label_class')) {
    function label_class($inputName, $errors, $extraClass = '')
    {
        return $errors->has($inputName) ? "class=\"error {$extraClass}\"" : "class=\"{$extraClass}\"";
    }
}

if (! function_exists('input_error')) {
    function input_error($inputName, $errors)
    {
        return $errors->has($inputName) ? '<p class="form-error">'. $errors->first($inputName) .'</p>' : '';
    }
}
