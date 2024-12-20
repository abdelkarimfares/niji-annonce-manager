<?php
declare(strict_types=1);

namespace Niji\AdManager\Controller\Adminhtml\Ad;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Niji\AdManager\Model\AdRepository;
use Psr\Log\LoggerInterface;

/**
 * Delete Ad Class
 *
 * This class is responsible for deleting the ad
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Delete extends Action
{
    /**
     * @inheirtDoc
     */
    const ADMIN_RESOURCE = 'Niji_AdManager::delete';

    /**
     * @param Context $context
     * @param AdRepository $adRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action\Context                   $context,
        private readonly AdRepository    $adRepository,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct($context);
    }

    /**
     * @inheirtDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $ad = $this->adRepository->getById((int)$id);
            $this->adRepository->delete($ad);
            $this->messageManager->addSuccessMessage(__('Ad is deleted Successfully.'));

            return $resultRedirect->setPath('*/*/');
        } catch (
        NoSuchEntityException
        |CouldNotDeleteException $ex
        ) {
            $this->messageManager->addExceptionMessage($ex);
        } catch (\Exception $ex) {
            $this->logger->error($ex);
            $this->messageManager->addErrorMessage(__('Something went wrong while deleting the ad.'));
        }

        return $resultRedirect->setRefererUrl();
    }
}
