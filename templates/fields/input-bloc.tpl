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
<fieldset
    {if isset($id)}id="{$id|escape:'html':'UTF-8'}"{/if}
    class="pgform__field{if isset($fieldsetClasses)} {$fieldsetClasses|clip:' '|escape:'html':'UTF-8'}{/if}{if isset($class)} {$class|escape:'html':'UTF-8'}{/if}"
>
    {if isset($label)}
        {include file="fields/partials/label.tpl" label=$label attr=$attr}
    {/if}

    {if isset($warning)}
        {include file="fields/partials/warning.tpl" warning=$warning}
    {/if}
    
    <div class="pgform__field__input">
        {include file="fields/partials/input.tpl" attr=$attr}

        {if isset($append)}
            {include file="fields/partials/append.tpl" append=$append}
        {/if}
    </div>

    {if isset($help)}
        {include file="fields/partials/help.tpl" help=$help}
    {/if}

    {if isset($errors)}
        {include file="fields/partials/errors.tpl" errors=$errors}
    {/if}
</fieldset>