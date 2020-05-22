<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\QuickExcludeVisitorIP;

use Piwik\Access;
use Piwik\DataTable\Row;
use Piwik\Plugin;

class QuickExcludeVisitorIP extends Plugin
{
    public function registerEvents()
    {
        return array(
            'Live.renderVisitorIcons' => 'addLinkToTemplate',
            'AssetManager.getJavaScriptFiles' => 'getJavaScriptFiles',
        );
    }

    public function addLinkToTemplate(&$outString, Row $visit)
    {
        if (Access::getInstance()->hasSuperUserAccess()) {
            $ip = $visit->getColumn("visitIp");
            $outString .= "<a class='quickExcludeButton' data-ip='$ip'>ignore</a>";
        }
    }

    public function getJavaScriptFiles(&$files)
    {
        $files[] = "plugins/QuickExcludeVisitorIP/javascripts/main.js";
    }
}
