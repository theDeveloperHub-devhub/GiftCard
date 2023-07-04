<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Plugin;

use Magento\Customer\Model\Session;

class Topmenu
{
    /**
     * @param Session $session
     */
    public function __construct(
        Session $session
    ) {
        $this->Session = $session;
    }
    public function afterGetHtml(\Magento\Theme\Block\Html\Topmenu $topmenu, $html)
    {
        $swappartyUrl = $topmenu->getUrl('developerhub/index/index');
        $magentoCurrentUrl = $topmenu->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        if (strpos($magentoCurrentUrl, 'developerhub/index/index') !== false) {
            $html .= "<li class=\"level0 nav-5 active level-top\">";
        } else {
            $html .= "<li class=\"level0 nav-4 level-top\">";
        }
        $html .= "<a href=\"" . $swappartyUrl . "\" class=\"level-top ui-corner-all\"><span class=\"ui-menu-icon ui-icon ui-icon-carat-1-e\"></span><span>" . __("Gift Card") . "</span></a>";
        $html .= "</li>";
        return $html;
    }
}
