<?php
declare(strict_types=1);

namespace Niji\AdManager\Controller\Ad;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\LayoutFactory;
use Niji\AdManager\Block\Slides;
use Magento\Framework\Controller\Result\RawFactory;

/**
 * Load Ads Class
 *
 * This class is responsible for load category banners
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Load implements ActionInterface
{
    /**
     * @param LayoutFactory $layoutFactory
     * @param RawFactory $resultRawFactory
     */
    public function __construct(
        private readonly LayoutFactory $layoutFactory,
        private readonly RawFactory    $resultRawFactory
    ){}

    /**
     * @inheirtDoc
     */
    public function execute()
    {
        $layout = $this->layoutFactory->create();
        $block = $layout->createBlock(Slides::class);
        $block->setTemplate('Niji_AdManager::banner/slides.phtml');

        return $this->resultRawFactory
            ->create()
            ->setContents($block->toHtml());
    }
}
