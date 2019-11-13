<?php
namespace Kraken\WistiaVideo\Helper;

use Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package Kraken\WistiaVideo\Helper
 */
class Data extends \Magento\Framework\Url\Helper\Data
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * Attribute code for "product video"
     */
    const PRODUCT_VIDEO_ATTRIBUTE = 'product_video';

    /**
     * XML Path
     */
    const XML_PATH_VIDEO_ASPECT_RATIO = 'kraken_wistiavideo/video_settings/aspect_ratio';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get current product instance
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->_coreRegistry->registry('product');
    }

    /**
     * Get video aspect ratio
     *
     * @return mixed
     */
    public function getVideoAspectRatio()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_VIDEO_ASPECT_RATIO);
    }

    /**
     * Get Wistia Video codes from product attribute
     *
     * @param $product
     * @return array
     */
    public function getVideoCodes($product) : array
    {
        $videoCodes = $product->getData(self::PRODUCT_VIDEO_ATTRIBUTE);
        $videoCodeLines = preg_split('#[\r\n]+#', $videoCodes);

        $parsedVideoCodes = array_filter(array_map('trim', $videoCodeLines));

        return $parsedVideoCodes;
    }
}
