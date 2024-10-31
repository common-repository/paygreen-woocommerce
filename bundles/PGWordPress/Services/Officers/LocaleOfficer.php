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

use PGI\Module\PGIntl\Interfaces\Officers\LocaleOfficerInterface;
use Exception;

/**
 * Class LocaleOfficer
 * @package PGWordPress\Services\Officers
 */
class LocaleOfficer implements LocaleOfficerInterface
{
    const LOCAL_SEPARATOR = '_';

    /**
     * @inheritDoc
     */
    public function getCustomerLocale()
    {
        return get_user_locale();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getCustomerCountry()
    {
        $customerLocale = $this->getCustomerLocale();

        return $this->getCountryFromLocale($customerLocale);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getCustomerLanguage()
    {
        $customerLocale = $this->getCustomerLocale();

        return $this->getLanguageFromLocale($customerLocale);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getShopLocale()
    {
        return get_locale();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getShopCountry()
    {
        $customerLocale = $this->getShopLocale();

        return $this->getCountryFromLocale($customerLocale);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getShopLanguage()
    {
        $customerLocale = $this->getShopLocale();

        return $this->getLanguageFromLocale($customerLocale);
    }

    /**
     * @param $locale
     * @return mixed
     * @throws Exception
     */
    private function getLanguageFromLocale($locale)
    {
        return $this->explodeLocale($locale, 0);
    }

    /**
     * @param $locale
     * @return mixed
     * @throws Exception
     */
    private function getCountryFromLocale($locale)
    {
        return $this->explodeLocale($locale, 1);
    }

    /**
     * @param string $locale
     * @param int $index
     * @return mixed
     * @throws Exception
     */
    private function explodeLocale($locale, $index)
    {
        $data = explode(self::LOCAL_SEPARATOR, $locale);

        if (!is_array($data) || (count($data) < 1)) {
            throw new Exception("Unable to parse locale : '$locale'.");
        }

        return $data[$index];
    }
}
