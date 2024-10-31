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

namespace PGI\Module\PGForm\Foundations\Fields;

use PGI\Module\PGForm\Services\Views\Fields\BasicFieldView;
use PGI\Module\PGFramework\Services\Handlers\SelectHandler;
use PGI\Module\PGIntl\Services\Translator;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGLog\Services\Logger;

/**
 * Class AbstractChoiceField
 * @package PGForm\Foundations\Fields
 */
abstract class AbstractChoiceField extends BasicFieldView
{
    /** @var SelectHandler */
    private $selectHandler;

    /** @var Translator */
    private $translator;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        SelectHandler $selectHandler,
        Translator $translator,
        LoggerInterface $logger
    ) {
        $this->selectHandler = $selectHandler;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    /**
     * @return SelectHandler
     */
    public function getSelectHandler()
    {
        return $this->selectHandler;
    }

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    public function translate(&$val)
    {
        $val = $this->translator->get($val);
    }
}
