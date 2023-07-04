<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Path;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Translate\Inline\StateInterface;

class AddToCart implements ActionInterface
{
    const EMAIL_TEMPLATE = 'giftcard_emailoptions_send';

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @param FormKey $formKey
     * @param RequestInterface $request
     * @param Cart $cart
     * @param ManagerInterface $messageManager
     * @param StateInterface $inlineTranslation
     * @param Escaper $escaper
     * @param ResultFactory $resultFactory
     * @param TransportBuilder $transportBuilder
     * @param DateTime $date
     * @param Product $product
     */
    public function __construct(
        FormKey $formKey,
        RequestInterface $request,
        Cart $cart,
        ManagerInterface $messageManager,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        ResultFactory $resultFactory,
        TransportBuilder $transportBuilder,
        DateTime $date,
        Product $product
    ) {
        $this->formKey = $formKey;
        $this->request = $request;
        $this->cart = $cart;
        $this->messageManager = $messageManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->resultFactory = $resultFactory;
        $this->date = $date;
        $this->transportBuilder = $transportBuilder;
        $this->product = $product;
    }

    public function execute()
    {
        $productId = $this->request->getPost();

        try {
            $productSku = 'custom_gift_card';
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $productFactory = $objectManager->get(ProductFactory::class);
            $check = $productFactory->create()->loadByAttribute('sku', $productSku);
            if ($check == false) {
                $this->product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_VIRTUAL)
                    ->setAttributeSetId(4) // Replace with the desired attribute set ID
                    ->setWebsiteIds([1]) // Replace with the desired website IDs
                    ->setName("Gift Card")
                    ->setSku('custom_gift_card')
                    ->setQty($productId['qty'])
                    ->setPrice(123)
                    ->setSpecialPrice(100)
                    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
                    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);

                $this->product->setData('sample_attribute', '122');
                $productRepository = $objectManager->get('\Magento\Catalog\Api\ProductRepositoryInterface');
                $product = $productRepository->save($this->product);
                $quote = $productId['id'];
                $this->cart->addProduct($product, $productId['qty']);
                $this->cart->save($quote);
            } else {
                $quote = $productId['id'];
                $this->cart->addProduct($check, $productId['qty']);
                $this->cart->save($quote);
            }
            $this->messageManager->addSuccessMessage(__('Product added to cart successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Failed to add product to cart.'));
        }
        $this->sendEmail1($productId);
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('checkout/cart/index');
        return $resultRedirect;
    }

    public function sendEmail1($productId)
    {
        $selectedDate = $productId['selected_date'];
        $email = $productId['email'];
        $nextDate = $this->date->date('d-m-y', strtotime($selectedDate . " +10 days"));

        $sendEmailTo = 'support@magento.com';
        $emailSender = $productId['sender_name'];
        $finalData = [
            'sender_name' => $emailSender,
            'expiry_date' => $nextDate,
            'recipient_name' => $sendEmailTo
        ];
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml($emailSender),
                'email' => $this->escaper->escapeHtml($email),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier(self::EMAIL_TEMPLATE)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $finalData])
                ->setFromByScope($sender)
                ->addTo($sendEmailTo)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __($e->getMessage())
            );
        }
    }
}
