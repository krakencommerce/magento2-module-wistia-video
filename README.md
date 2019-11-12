# Kraken WistiaVideo Extension

## Description

Embeds Wistia videos on product detail page, in MagicZoomPlus MagicScroll thumbnails and on the page

## Usage Instructions

* Install extension (make sure you apply the patch in the `patches` folder)
* Edit any product and add a Wistia embed code (will be a string that looks like `vuli55yxky`). Save product.
* View product on frontend and you should see Wistia video embedded on page, in a "Videos" tab

## Installation Instructions

### Option 1 - Install extension using Composer (default approach)

```bash
composer config repositories.kraken/module-wistia-video git https://github.com/krakencommerce/magento2-module-wistia-video.git
composer require kraken/module-wistia-video:dev-master
bin/magento module:enable --clear-static-content Kraken_WistiaVideo
bin/magento setup:upgrade
bin/magento cache:flush
```

### Option 2 - Install extension by copying files into project (only if the project requires it for some reason)

```bash
mkdir -p app/code/Kraken/WistiaVideo
git archive --format=tar --remote=git@github.com:krakencommerce/magento2-module-wistia-video.git master | tar xf - -C app/code/Kraken/WistiaVideo/
bin/magento module:enable --clear-static-content Kraken_WistiaVideo
bin/magento setup:upgrade
bin/magento cache:flush
```

## Uninstallation Instructions

These instructions work regardless of how you installed the extension:

```bash
bin/magento module:disable --clear-static-content Kraken_WistiaVideo
rm -rf app/code/Kraken/WistiaVideo
composer remove kraken/module-wistia-video
mr2 db:query 'DELETE FROM `setup_module` WHERE `module` = "Kraken_WistiaVideo"'
bin/magento cache:flush
```
