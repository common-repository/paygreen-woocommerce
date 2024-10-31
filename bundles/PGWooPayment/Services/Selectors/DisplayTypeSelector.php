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

namespace PGI\Module\PGWooPayment\Services\Selectors;

use PGI\Module\PGFramework\Foundations\AbstractSelector;
use Exception;

/**
 * Class DisplayTypeSelector
 * @package PGWooPayment\Services\Selectors
 */
class DisplayTypeSelector extends AbstractSelector
{
    /**
     * @return array
     * @throws Exception
     */
    protected function buildChoices()
    {
        return array(
            'DEFAULT' => 'forms.button.fields.display_type.values.all',
            'PICTURE' => 'forms.button.fields.display_type.values.picture',
            'TEXT' => 'forms.button.fields.display_type.values.text'
        );
    }

    protected function getTranslationRoot()
    {
        return '';
    }
}
