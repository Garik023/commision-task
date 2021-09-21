<?php

declare(strict_types=1);

namespace CommissionTask\Contract\Service;

/**
 *
 * Configuration's interface.
 */
interface Config
{
    /**
     * Returns configuration values in configuration file by given path.
     * Returns default value if configuration was not found.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null);

    /**
     * Sets new configuration by given path.
     *
     * @param $value
     */
    public function set(string $path, $value);
}
