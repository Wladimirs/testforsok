<?php

namespace testforsok;

trait TSingleton
{
    /**
     * Hold the class instance.
     * @var object
     */
    private static $instance;

    /**
     * Create a new function instance.
     * The object is created from within the class itself only if the class has no instance.
     * @return \testforsok\TSingleton
     */
    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}