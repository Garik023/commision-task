<?php

declare(strict_types=1);

namespace CommissionTask\Factory;

/**
 *
 * Configuration's interface.
 */
interface Config
{
    /**
     * Gets config files values by passed path, or returns default
     *
     * @param mixed|null $default
     */
    public function get(string $path, $default = null);

}
