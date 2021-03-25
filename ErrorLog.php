<?php
namespace ErrorLog;
class ErrorLog
{
    private static $errorInstance = null;

    private function __construct()
    {
    }

    public static function getErrorInstance()
    {
        if (static::$errorInstance == null)
            static::$errorInstance = new ErrorLog();
        return static::$errorInstance;
    }

    public function writeError($errorMessage)
    {
        echo "<script>
                    console.log('" . $errorMessage . "')
                </script>";
    }
}
