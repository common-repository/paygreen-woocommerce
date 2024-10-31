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

namespace PGI\Module\PGWordPress\Services\Officers;

use PGI\Module\PGModule\Interfaces\Officers\SettingsOfficerInterface;

/**
 * Class SystemSettingsOfficer
 * @package PGWordPress\Services\Officers
 */
class SystemSettingsOfficer implements SettingsOfficerInterface
{
    const SETTINGS_PREFIX = 'paygreen_';

    /**
     * @inheritDoc
     */
    public function getOption($name, $defaultValue)
    {
        $name = $this->getOptionName($name);

        $value = get_site_option($name);

        if ($value === false) {
            $value = $defaultValue;
        } else {
            $value = unserialize($value);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setOption($name, $value)
    {
        $name = $this->getOptionName($name);

        $previousValue = get_site_option($name);

        if ($previousValue === false) {
            $result = add_site_option($name, serialize($value));
        } else {
            $result = update_site_option($name, serialize($value));
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function unsetOption($name)
    {
        $name = $this->getOptionName($name);

        return delete_site_option($name);
    }

    protected function getOptionName($name)
    {
        return self::SETTINGS_PREFIX . $name;
    }

    public function clean()
    {
        wp_cache_delete('alloptions', 'options');
    }
}
