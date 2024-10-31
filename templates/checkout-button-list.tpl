{*
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
 *}
<div id="paygreen-payment-button-list">
    <ul class="pg-checkout__button-list">
        {foreach from=$options item=option name=options}
            <li class="pg-checkout__payment-button pg-checkout__payment-button--{$option.displayType}">
                <input
                    type="radio"
                    name="wcpaygreen_buttons_id"
                    id="wcpaygreen_buttons_id_{$option.id}"
                    value="{$option.id}"
                    {if $smarty.foreach.options.first}checked="checked"{/if}
                />

                <label for="wcpaygreen_buttons_id_{$option.id}">
                    {template name="partials/checkout-option" option=$option}
                </label>
            </li>
        {/foreach}
    </ul>
</div>