<?php

namespace FondOfKudu\Zed\Kletties;

use FondOfKudu\Shared\Kletties\KlettiesConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class KlettiesConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getKnownVendor(): array
    {
        return $this->get(KlettiesConstants::KNOWN_VENDOR, []);
    }

    /**
     * @return string
     */
    public function getAttributeSkuSuffix(): string
    {
        return $this->get(KlettiesConstants::SKU_SUFFIX, '_sku');
    }
}
