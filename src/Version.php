<?php

namespace LaravelBs5Kit;

/**
 * BS5 Starter Kit Version Information
 */
class Version
{
    /**
     * The current version of BS5 Starter Kit.
     */
    public const VERSION = '1.0.9';

    /**
     * The release date.
     */
    public const RELEASE_DATE = '2025-06-30';

    /**
     * Get the current version.
     */
    public static function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * Get the release date.
     */
    public static function getReleaseDate(): string
    {
        return self::RELEASE_DATE;
    }

    /**
     * Get version information.
     */
    public static function getInfo(): array
    {
        return [
            'version' => self::VERSION,
            'release_date' => self::RELEASE_DATE,
            'name' => 'BS5 Starter Kit',
            'description' => 'Pure Bootstrap 5 starter kit for Laravel',
        ];
    }
}
