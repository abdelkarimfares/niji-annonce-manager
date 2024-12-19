<?php
declare(strict_types=1);

namespace Niji\AdManager\Controller\Adminhtml\Ad;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Niji\AdManager\Api\Data\AdInterface;
use Niji\AdManager\Model\AdRepository;
use Niji\AdManager\Model\AdFactory;
use Niji\AdManager\Helper\Ad\Validator as AdValidator;
use Psr\Log\LoggerInterface;

/**
 * Save Class
 *
 * This class is responsible for saving the ad
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Save extends Action
{
    /**
     * @inheirtDoc
     */
    const ADMIN_RESOURCE = 'Niji_AdManager::edit';

    /**
     * @param Context $context
     * @param AdRepository $adRepository
     * @param AdFactory $adFactory
     * @param AdValidator $validator
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action\Context                   $context,
        private readonly AdRepository    $adRepository,
        private readonly AdFactory       $adFactory,
        private readonly AdValidator     $validator,
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
        $data = $this->getRequest()->getPostValue();

        $id = $data["entity_id"] ?? null;
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $ad = !$id
                ? $this->buildAd($data)
                : $this->buildAd($data, $this->adRepository->getById((int)$id));

            $this->validator->validate($ad);

            $this->adRepository->save($ad);
            $this->messageManager->addSuccessMessage(__('Ad Data saved Successfully.'));

            return $resultRedirect->setPath('*/*/');
        } catch (
        LocalizedException
        |NoSuchEntityException
        |StateException
        |InputException
        |ValidatorException
        |CouldNotSaveException $ex
        ) {
            $this->messageManager->addExceptionMessage($ex);
        } catch (\Exception $ex) {
            $this->logger->error($ex);
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the ad data.'));
        }

        return $resultRedirect->setRefererUrl();
    }

    /**
     * Build Ad Model From incoming data
     *
     * @param array $data
     * @param AdInterface|null $ad
     * @return AdInterface
     */
    private function buildAd(array $data, AdInterface $ad = null): AdInterface
    {
        if (!$ad) {
            $ad = $this->adFactory->create();
        }

        return $ad
            ->setLabel($data['label'] ?? '')
            ->setContent($data['content'] ?? '')
            ->setLink($data['link'] ?? '')
            ->setStartedAt($data['started_at'] ?? '')
            ->setEndedAt($data['ended_at'] ?? '')
            ->setCategoryIds($data['categories'] ?? []);
    }
}