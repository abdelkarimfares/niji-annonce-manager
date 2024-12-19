<?php
declare(strict_types=1);

namespace Niji\AdManager\Controller\Adminhtml\Ad;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index Class
 *
 * This class is responsible for rendering the list of ads
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @inheirtDoc
     */
    const ADMIN_RESOURCE = 'Niji_AdManager::listing';

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        private readonly PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute(): Page
    {
        $page = $this->resultPageFactory->create();
        $page->setActiveMenu('Niji_AdManager::Manager')
            ->getConfig()
            ->getTitle()
            ->prepend(__('Manage Ads'));

        return $page;
    }
}
