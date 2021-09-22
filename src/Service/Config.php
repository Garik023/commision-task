<?php

declare(strict_types=1);

namespace CommissionTask\Service;

use CommissionTask\Factory\Config as ConfigFactory;

class Config implements ConfigFactory
{
    /**
     * Loaded configurations.
     *
     * @var array
     */
    protected array $configurations = [];

    /**
     * @var array
     */
    private static array $instances = [];

    protected function __construct()
    {
        $this->getConfigs();
    }

    /**
     * Returns new or existing instance of the Config class.
     */
    public static function getInstance(): Config
    {
        $className = static::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static();
        }
        return self::$instances[$className];
    }

    /**
     * Gets config files values by passed path, or returns default
     *
     * @param mixed|null $default
     */
    public function get(string $path, $default = null)
    {
        $configuration = $this->configurations;
        if (!empty($path)) {
            $parts = explode('.', $path);
            foreach ($parts as $part) {
                if (isset($configuration[$part])) {
                    $configuration = $configuration[$part];
                } else {
                    return $default;
                }
            }
        }
        return $configuration;
    }

    /**
     * Gets config files values located in App/config folder
     */
    private function getConfigs()
    {
        $configDirPath = getcwd().'/config';
        foreach (scandir($configDirPath) as $directoryItem) {
            $directoryItemFullPath = $configDirPath.'/'.$directoryItem;
            if (is_file($directoryItemFullPath)) {
                $fileName = pathinfo($directoryItem, PATHINFO_FILENAME);
                $this->configurations[$fileName] = require $directoryItemFullPath;
            }
        }
    }
}
