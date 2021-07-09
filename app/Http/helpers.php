<?php
/**
 * Created by Muhaimenul Islam.
 * User: muhaimenul
 * Date: 7/10/21
 * Time: 1:39 AM
 */
if (!function_exists('upload_file')) {
    function upload_file($file, $dir = 'files', $metadata = null)
    {
        if (!is_file($file)) return null;
        return \Illuminate\Support\Facades\Storage::disk('local')->put($dir, $file);
    }
}

if (!function_exists('get_file')) {
    function get_file($filename)
    {
        return \Illuminate\Support\Facades\Storage::disk('local')->url($filename);
    }
}

