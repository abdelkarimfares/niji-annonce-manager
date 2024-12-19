<?php

namespace Niji\AdManager\Controller\Adminhtml\Ad;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\ForwardFactory;

/**
 * New Ad Class
 *
 * This class is responsible for creating new ad
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class NewAction extends Action
{
    /**
     * @inheirtDoc
     */
    const ADMIN_RESOURCE = 'Niji_AdManager::edit';

    /**
     * @param Action\Context $context
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Action\Context $context,
        private readonly ForwardFactory $forwardFactory
    ) {
        parent::__construct($context);
    }

    /**
     * @inheirtDoc
     */
    public function execute()
    {
        return $this->forwardFactory->create()->forward('edit');
    }
}