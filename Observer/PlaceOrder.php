<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class PlaceOrder implements ObserverInterface
{
    /**
     * @var SessionManagerInterface
     */
    protected $session;
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @param SessionManagerInterface $session
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        SessionManagerInterface $session,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->session = $session;
        $this->orderRepository = $orderRepository;
    }
    public function execute(Observer $observer)
    {
        $order= $observer->getEvent()->getOrder();
        $data = $this->session->getMyData();
        if ($data) {
            $order->setBaseGrandTotal($data);
            $order->setGrandTotal($data);
            $order->setBaseSubtotal($data);
            $order->setSubtotal($data);
            $this->session->setMyData(null);
            $this->orderRepository->save($order);
        } else {
            $this->orderRepository->save($order);
        }
    }
}
