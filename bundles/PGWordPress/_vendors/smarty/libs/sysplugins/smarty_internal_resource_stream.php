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
 * Smarty Internal Plugin Resource Stream
 * Implements the streams as resource for Smarty template
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 * @author     Rodney Rehm
 */

/**
 * Smarty Internal Plugin Resource Stream
 * Implements the streams as resource for Smarty template
 *
 * @link       http://php.net/streams
 * @package    Smarty
 * @subpackage TemplateResources
 */
class Smarty_Internal_Resource_Stream extends Smarty_Resource_Recompiled
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
        if (strpos($source->resource, '://') !== false) {
            $source->filepath = $source->resource;
        } else {
            $source->filepath = str_replace(':', '://', $source->resource);
        }
        $source->uid = false;
        $source->content = $this->getContent($source);
        $source->timestamp = $source->exists = !!$source->content;
    }

    /**
     * Load template's source from stream into current template object
     *
     * @param Smarty_Template_Source $source source object
     *
     * @return string template source
     */
    public function getContent(Smarty_Template_Source $source)
    {
        $t = '';
        // the availability of the stream has already been checked in Smarty_Resource::fetch()
        $fp = fopen($source->filepath, 'r+');
        if ($fp) {
            while (!feof($fp) && ($current_line = fgets($fp)) !== false) {
                $t .= $current_line;
            }
            fclose($fp);
            return $t;
        } else {
            return false;
        }
    }

    /**
     * modify resource_name according to resource handlers specifications
     *
     * @param Smarty  $smarty        Smarty instance
     * @param string  $resource_name resource_name to make unique
     * @param boolean $isConfig      flag for config resource
     *
     * @return string unique resource name
     */
    public function buildUniqueResourceName(Smarty $smarty, $resource_name, $isConfig = false)
    {
        return get_class($this) . '#' . $resource_name;
    }
}
