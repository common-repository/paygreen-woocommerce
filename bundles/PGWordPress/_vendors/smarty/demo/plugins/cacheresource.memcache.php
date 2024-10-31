<?php
/**
 * 2014 - 2023 Watt Is It
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License X11
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@paygreen.fr so we can send you a copy immediately.
 *
 * @author    PayGreen <contact@paygreen.fr>
 * @copyright 2014 - 2023 Watt Is It
 * @license   https://opensource.org/licenses/mit-license.php MIT License X11
 * @version   4.10.2
 *
 */

/**
 * Memcache CacheResource
 * CacheResource Implementation based on the KeyValueStore API to use
 * memcache as the storage resource for Smarty's output caching.
 * Note that memcache has a limitation of 256 characters per cache-key.
 * To avoid complications all cache-keys are translated to a sha1 hash.
 *
 * @package CacheResource-examples
 * @author  Rodney Rehm
 */
class Smarty_CacheResource_Memcache extends Smarty_CacheResource_KeyValueStore
{
    /**
     * memcache instance
     *
     * @var Memcache
     */
    protected $memcache = null;

    /**
     * Smarty_CacheResource_Memcache constructor.
     */
    public function __construct()
    {
        if (class_exists('Memcached')) {
            $this->memcache = new Memcached();
        } else {
            $this->memcache = new Memcache();
        }
        $this->memcache->addServer('127.0.0.1', 11211);
    }

    /**
     * Read values for a set of keys from cache
     *
     * @param array $keys list of keys to fetch
     *
     * @return array   list of values with the given keys used as indexes
     * @return boolean true on success, false on failure
     */
    protected function read(array $keys)
    {
        $res = array();
        foreach ($keys as $key) {
            $k = sha1($key);
            $res[$key] = $this->memcache->get($k);
        }
        return $res;
    }

    /**
     * Save values for a set of keys to cache
     *
     * @param array $keys   list of values to save
     * @param int   $expire expiration time
     *
     * @return boolean true on success, false on failure
     */
    protected function write(array $keys, $expire = null)
    {
        foreach ($keys as $k => $v) {
            $k = sha1($k);
            if (class_exists('Memcached')) {
                $this->memcache->set($k, $v, $expire);
            } else {
                $this->memcache->set($k, $v, 0, $expire);
            }
        }
        return true;
    }

    /**
     * Remove values from cache
     *
     * @param array $keys list of keys to delete
     *
     * @return boolean true on success, false on failure
     */
    protected function delete(array $keys)
    {
        foreach ($keys as $k) {
            $k = sha1($k);
            $this->memcache->delete($k);
        }
        return true;
    }

    /**
     * Remove *all* values from cache
     *
     * @return boolean true on success, false on failure
     */
    protected function purge()
    {
        return $this->memcache->flush();
    }
}
