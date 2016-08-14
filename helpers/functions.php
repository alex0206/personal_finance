<?php

/**
 * functions.php file.
 * Global shorthand functions for commonly used Yii methods.
 */

/**
 * Returns the application instance.
 * @return \yii\web\Application
 */
function app()
{
    return Yii::$app;
}

/**
 * Dumps the given variable using CVarDumper::dumpAsString().
 * @param mixed $var
 * @param int $depth
 * @param bool $highlight
 */
function dump($var, $depth = 10, $highlight = true)
{
    return \yii\helpers\VarDumper::dump($var, $depth, $highlight);
}

/**
 * Debug function with die() after
 * dd($var);
 */
function dd($var, $showDebugCallPath = false, $depth = 10, $highlight = true)
{
    if ($showDebugCallPath) {
        $db = current(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1));
        $dump = [
            'file' => $db['file'],
            'line' => $db['line'],
            'dump' => $var,
        ];
    } else {
        $dump = $var;
    }

    dump($dump, $depth, $highlight);
    die();
}

/**
 * Returns user component.
 */
function user()
{
    return app()->getUser()->identity;
}

/**
 * Returns post data
 */
function post($name = null, $defaultValue = null)
{
    return app()->request->post($name, $defaultValue);
}

/**
 * Returns get data
 */
function get($name = null, $defaultValue = null)
{
    return app()->request->get($name, $defaultValue);
}

/**
 * Yii translate
 */
function t($category, $message, $params = [], $language = null)
{
    return Yii::t($category, $message, $params, $language);
}