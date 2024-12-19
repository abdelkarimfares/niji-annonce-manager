<?php
declare(strict_types=1);

namespace Niji\AdManager\Controller\Adminhtml\Ad;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * New Ad Class
 *
 * This class is responsible for updating ad
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Edit extends Action
{
    /**
     * @inheirtDoc
     */
    const ADMIN_RESOURCE = 'Niji_AdManager::edit';

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
     * @inheirtDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $page = $this->resultPageFactory->create();

        $page->setActiveMenu('Niji_AdManager::Manager')
            ->getConfig()
            ->getTitle()
            ->prepend($id ? __('Edit Ad') : __('Add New Ad'));

        return $page;
    }
}
