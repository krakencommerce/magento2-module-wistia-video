<?php
/**
 * @category    Kraken
 * @copyright   Copyright (c) 2019 Kraken Commerce
 */

namespace Kraken\WistiaVideo\Plugin\Catalog\Block\Product\View;

use \Kraken\WistiaVideo\Helper\Data as Helper;

class Details
{
    /**
     * Code that will be used for the new tab/section added to the product page
     */
    const SECTION_CODE = 'video';

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * Details constructor.
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @return bool
     */
    protected function productHasVideo()
    {
        return !empty(trim($this->helper->getProduct()->getProductVideo()));
    }

    /**
     * @param \Magento\Catalog\Block\Product\View\Details\Interceptor $interceptor
     */
    public function beforeToHtml($interceptor)
    {
        if ($interceptor->getNameInLayout() == 'product.info.details' && $this->productHasVideo()) {
            $code = self::SECTION_CODE;
            $alias = 'attribute_' . $code;
            $block = $interceptor->getLayout()->createBlock(
                \Magento\Framework\View\Element\Template::class,
                $alias,
                ['data' => [
                    'template' => 'Kraken_WistiaVideo::product/video.phtml',
                    'product' => $this->helper->getProduct(),
                    'title' => __('Product Video'),
                    'sort_order' => 29
                ]]
            );

            $interceptor->setChild($alias, $block);
        }
    }

    /**
     * @param \Magento\Catalog\Block\Product\View\Details\Interceptor $interceptor
     * @param array $result
     * @return array
     */
    public function afterGetGroupChildNames($interceptor, $result)
    {
        if ($interceptor->getNameInLayout() == 'product.info.details') {
            if ($this->productHasVideo()) {
                $code = self::SECTION_CODE;
                array_push($result, 'attribute_' . $code);
            }
            return $result;
        }
    }
}
