<?php

namespace SeaweedFS\Laravel;

use GrahamCampbell\Manager\AbstractManager;
use SeaweedFS\Cache\FileCache;
use SeaweedFS\SeaweedFS;

/**
 * SeaweedFS Manager Class, extending GrahamCampbell's Manager package.
 *
 * @package SeaweedFS\Laravel
 */
class SeaweedFSManager extends AbstractManager {

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return object
     */
    protected function createConnection(array $config) {
        $cache = null;

        switch (array_get($config, 'cache', 'laravel')) {
            case 'file':
                $cache = new FileCache(array_get($config, 'root', storage_path('seaweedfs')));
                break;
            case 'default':
            case 'laravel':
                $cache = new LaravelCache(app('cache')->store(array_get($config, 'cache_store')));
                break;
        }

        return new SeaweedFS($config['master'], array_get($config, 'scheme', 'http'), $cache);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName() {
        return 'seaweedfs';
    }
}