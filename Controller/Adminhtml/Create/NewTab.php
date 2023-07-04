<?php declare(strict_types = 1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\Create;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class NewTab extends Action
{
    /**
     * @return ResponseInterface|ResultInterface|null
     */
    public function execute()
    {
        return $this->_forward("newedit");
    }
}
