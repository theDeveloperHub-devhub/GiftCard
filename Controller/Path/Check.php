<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Path;

use DeveloperHub\GiftCard\Model\ResourceModel\Reviews\CsvCollectionFactory;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;

class Check implements ActionInterface
{

    /**
     * @var CsvCollectionFactory
     */
    private $_csvcollectionFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    protected $session;

    /**
     * @param PageFactory $pageFactory
     * @param Cart $cart
     * @param RequestInterface $request
     * @param SessionManagerInterface $session
     * @param JsonFactory $jsonFactory
     * @param CsvCollectionFactory $_csvcollectionFactory
     */
    public function __construct(
        PageFactory $pageFactory,
        Cart $cart,
        RequestInterface $request,
        SessionManagerInterface $session,
        JsonFactory $jsonFactory,
        CsvCollectionFactory $_csvcollectionFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->cart = $cart;
        $this->session = $session;
        $this->_csvcollectionFactory = $_csvcollectionFactory;
    }
    public function execute()
    {
        $fieldData = $this->request->getParam('myValue');
        $subtotal = $this->cart->getQuote()->getSubtotal();
        $result = $this->jsonFactory->create();
        $collection = $this->_csvcollectionFactory->create();
        $data = $collection->getData();
        foreach ($data as $items) {
            $status = $items['status'];
            if ($status == 'Used') {
                $usedStatus[] = [
                    'code' =>$items['code'],
                    'current_value' => $items['current_value']
                ];
            }
        }
        foreach ($usedStatus as $item) {
            $codeValue = $item['code'];
            if ($codeValue == $fieldData) {
                $currentValue = $item['current_value'];
                $discount = $subtotal - $currentValue;
                $this->session->setMyData($discount);
                return $result->setData(['response' => 'The Gift Card code is valid', 'value' => 1,
                    'subtotal' => $discount]);
            }
        }
        return $result->setData(['response' => 'The Gift Card code is not valid' , 'value' => 0]);
    }
}
