<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\QuickExcludeVisitorIP;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugins\SitesManager\API as APISitesManager;

class Controller extends \Piwik\Plugin\Controller
{

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    private function response($message, $type)
    {
        return json_encode(["message" => $message, "options" => ["title" => "QuickExcludeVisitorIP", "context" => $type]]);
    }

    public function ignoreIP()
    {
        Piwik::checkUserHasSuperUserAccess();
        @header('Content-Type: application/json; charset=utf-8');
        $ip = Common::getRequestVar('ip', null, 'string');
        $ignoredIPstr = APISitesManager::getInstance()->getExcludedIpsGlobal();
        $ignoredIPs = explode(",", $ignoredIPstr);
        if (in_array($ip, $ignoredIPs)) {
            return $this->response("IP was already on ignore list", "warning");
        }

        $ignoredIPs[] = $ip;

        $ignoredIPstr = implode(",", $ignoredIPs);

        APISitesManager::getInstance()->setGlobalExcludedIps($ignoredIPstr);

        return $this->response("successfully added \"$ip\" to ignore list", "success");
    }
}