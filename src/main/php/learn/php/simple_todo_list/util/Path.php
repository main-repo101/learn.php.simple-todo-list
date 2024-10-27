<?php


namespace learn\php\simple_todo_list\util;

class Path {
    public static function sanitize(
        array | string $path
    ): array | string | null {
        if (is_array($path)) {
            //REM: Iterate over each element in the array and sanitize it
            foreach ($path as &$p)
                self::sanitizePath($p);
            return $path;
        } 
        //REM: Directly sanitize the string
        self::sanitizePath($path);
        return $path;
    }

    private static function sanitizePath(
        string & $path
    ) {
        $path = preg_replace("#[/\\\\]+#", "/", $path );
        $path = preg_replace("#[.]+/#", "", $path );
    }
}
