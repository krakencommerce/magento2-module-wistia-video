<?php
/**
 * @category    KrakenCommerce
 * @copyright   Copyright (c) 2019 Kraken, LLC
 */
namespace Kraken\WistiaVideo\Plugin\Block\Product\View;

use \Kraken\WistiaVideo\Helper\Data as Helper;

class GalleryPlugin
{
    /**
     * Data Object Factory
     *
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $dataObjectFactory;

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var null|\Magento\Catalog\Model\Product
     */
    protected $parentConfigurable;

    public function __construct(
        \Magento\Framework\DataObjectFactory $dataObjectFactory,
        Helper $helper,
        \Magento\Framework\View\Asset\Repository $assetRepo
    ) {
        $this->dataObjectFactory = $dataObjectFactory;
        $this->helper = $helper;
        $this->assetRepo = $assetRepo;
    }

    /**
     * Add "fake" media item for the Wistia Video
     *
     * @param \MagicToolbox\MagicZoomPlus\Block\Product\View\Gallery $subject
     * @param callable $proceed
     * @param null $product
     * @return \Magento\Framework\Data\Collection
     * @throws \Exception
     */
    public function aroundGetGalleryImagesCollection(\MagicToolbox\MagicZoomPlus\Block\Product\View\Gallery $subject, callable $proceed, $product = null)
    {
        /** @var \Magento\Framework\Data\Collection $result */
        $result = $proceed($product);

        if ($this->parentConfigurable) {
            $product = $this->parentConfigurable;
        }

        if ($product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
            $this->parentConfigurable = $product;
        }

        $videoCodes = $this->helper->getVideoCodes($product);
        if (count($videoCodes)) {

            $i = 0;
            foreach ($videoCodes as $videoCode) {
                $i++;
                $videoId = 'wistia_video_id_' . $product->getId() . $i;

                $wistiaVideo = $this->dataObjectFactory->create();

                $thumbnailImageUrl = $this->assetRepo->getUrl('Kraken_WistiaVideo::images/video_thumbnail.svg');

                $wistiaVideo->setData([
                    'id' => '99999' . $i,
                    'value_id' => null,
                    'file' => null,
                    'media_type' => "external-video",
                    'entity_id' => "99999",
                    'label' => null,
                    'position' => "10",
                    'disabled' => "0",
                    'label_default' => null,
                    'position_default' => "10",
                    'disabled_default' => "0",
                    'video_provider' => '',
                    'video_url' => $videoId,
                    'video_title' => $product->getName(),
                    'video_description' => '',
                    'video_metadata' => '',
                    'video_provider_default' => '',
                    'video_url_default' => null,
                    'video_title_default' => null,
                    'video_description_default' => null,
                    'video_metadata_default' => '',
                    'url' => $thumbnailImageUrl,
                    'path' => null,
                    'small_image_url' => $thumbnailImageUrl
                ]);

                $result->addItem($wistiaVideo);
            }
        }

        return $result;
    }
}