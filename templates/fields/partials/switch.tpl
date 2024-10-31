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
<div class="pgform__field__switch">
    <input
        type="radio"
        name="{$attr.name|escape:'html':'UTF-8'}"
        id="{$attr.id|escape:'html':'UTF-8'}_off"
        value="0"
        class="pgform__field__switch__off"
        {if not $attr.value}checked="checked"{/if}
    />

    <label for="{$attr.id|escape:'html':'UTF-8'}_off">
        {'misc.forms.default.buttons.no'|pgtrans}
    </label>

    <input
        type="radio"
        name="{$attr.name|escape:'html':'UTF-8'}"
        id="{$attr.id|escape:'html':'UTF-8'}_on"
        value="1"
        class="pgform__field__switch__on"
        {if $attr.value}checked="checked"{/if}
    />

    <label for="{$attr.id|escape:'html':'UTF-8'}_on">
        {'misc.forms.default.buttons.yes'|pgtrans}
    </label>
</div>