<?php declare(strict_types = 1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\Create;

use DeveloperHub\GiftCard\Model\ReviewsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Session\SessionManagerInterface;

class Save extends Action
{
    /**
     * @var ReviewsFactory
     */
    protected $_reviewFactory;

    protected $sessionManager;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @param Context $context
     * @param ReviewsFactory $reviewsFactory
     * @param SessionManagerInterface $sessionManager
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Context $context,
        ReviewsFactory $reviewsFactory,
        SessionManagerInterface $sessionManager,
        ResourceConnection $resourceConnection
    ) {
        $this->_reviewFactory = $reviewsFactory;
        $this->resourceConnection = $resourceConnection;
        $this->sessionManager = $sessionManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $reviewId = isset($data['id']) ? $data['id'] : '';
        $rows = [];
        $this->sessionManager->start();
        $myData = $this->sessionManager->getData('my_data');
        $csvData = $this->getCsvData($myData);
        $connection  = $this->resourceConnection->getConnection();
        $tableName   = $connection->getTableName('csv_data');
        array_shift($csvData);
        foreach ($csvData as $item) {
            $value = [
                'code' => $item[0],
                'status' => $item[1],
                'initial_value' => $item[2],
                'current_value' => $item[3],
                'expiry_date' => $item[4]
            ];
            $rows[] = $value;
        }
        $this->resourceConnection->getConnection()
            ->insertOnDuplicate(
                $tableName,
                $rows
            );
        if (!$data) {
            $this->_redirect('developer_hub/create/create');
        }
        try {
            $rowData = $this->_reviewFactory->create()->load($reviewId);
            if (!$rowData->getId() && $reviewId) {
                $this->messageManager->addErrorMessage(__('row data no longer exist.'));
                $this->_redirect('developer_hub/create/create');
            }
            $rowData->setData($data);
            $rowData->save();
            $this->messageManager->addSuccessMessage(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        $this->_redirect('developer_hub/create/create');
    }
    protected function getCsvData($file)
    {
        $csvData = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $csvData[] = $data;
            }

            fclose($handle);
        }

        return $csvData;
    }
}
