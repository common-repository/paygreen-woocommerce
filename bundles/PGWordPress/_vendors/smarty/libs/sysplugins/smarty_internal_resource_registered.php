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
 * Smarty Internal Plugin Resource Registered
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 * @author     Rodney Rehm
 */

/**
 * Smarty Internal Plugin Resource Registered
 * Implements the registered resource for Smarty template
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @deprecated
 */
class Smarty_Internal_Resource_Registered extends Smarty_Resource
{
    /**
     * populate Source Object with meta data from Resource
     *
     * @param Smarty_Template_Source   $source    source object
     * @param Smarty_Internal_Template $_template template object
     *
     * @return void
     */
    public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template = null)
    {
        $source->filepath = $source->type . ':' . $source->name;
        $source->uid = sha1($source->filepath . $source->smarty->_joined_template_dir);
        $source->timestamp = $this->getTemplateTimestamp($source);
        $source->exists = !!$source->timestamp;
    }

    /**
     * populate Source Object with timestamp and exists from Resource
     *
     * @param Smarty_Template_Source $source source object
     *
     * @return void
     */
    public function populateTimestamp(Smarty_Template_Source $source)
    {
        $source->timestamp = $this->getTemplateTimestamp($source);
        $source->exists = !!$source->timestamp;
    }

    /**
     * Get timestamp (epoch) the template source was modified
     *
     * @param Smarty_Template_Source $source source object
     *
     * @return integer|boolean        timestamp (epoch) the template was modified, false if resources has no timestamp
     */
    public function getTemplateTimestamp(Smarty_Template_Source $source)
    {
        // return timestamp
        $time_stamp = false;
        call_user_func_array(
            $source->smarty->registered_resources[ $source->type ][ 0 ][ 1 ],
            array($source->name, &$time_stamp, $source->smarty)
        );
        return is_numeric($time_stamp) ? (int)$time_stamp : $time_stamp;
    }

    /**
     * Load template's source by invoking the registered callback into current template object
     *
     * @param Smarty_Template_Source $source source object
     *
     * @return string                 template source
     * @throws SmartyException        if source cannot be loaded
     */
    public function getContent(Smarty_Template_Source $source)
    {
        // return template string
        $content = null;
        $t = call_user_func_array(
            $source->smarty->registered_resources[ $source->type ][ 0 ][ 0 ],
            array($source->name, &$content, $source->smarty)
        );
        if (is_bool($t) && !$t) {
            throw new SmartyException("Unable to read template {$source->type} '{$source->name}'");
        }
        return $content;
    }

    /**
     * Determine basename for compiled filename
     *
     * @param Smarty_Template_Source $source source object
     *
     * @return string                 resource's basename
     */
    public function getBasename(Smarty_Template_Source $source)
    {
        return basename($source->name);
    }
}
