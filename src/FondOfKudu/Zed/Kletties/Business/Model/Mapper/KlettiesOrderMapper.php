<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Mapper;

use ArrayObject;
use FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToLocaleFacadeInterface;
use FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToStoreFacadeInterface;
use FondOfKudu\Zed\Kletties\KlettiesConfig;
use FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\KlettiesVendorTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;

class KlettiesOrderMapper implements KlettiesOrderMapperInterface
{
    /**
     * @var string
     */
    protected const FALLBACK_LOCALE = '_';

    /**
     * @var \FondOfKudu\Zed\Kletties\KlettiesConfig
     */
    protected KlettiesConfig $config;

    /**
     * @var \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToLocaleFacadeInterface
     */
    protected KlettiesToLocaleFacadeInterface $localeFacade;

    /**
     * @var \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToStoreFacadeInterface
     */
    protected KlettiesToStoreFacadeInterface $storeFacade;

    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface
     */
    protected KlettiesRepositoryInterface $repository;

    /**
     * @param \FondOfKudu\Zed\Kletties\KlettiesConfig $config
     * @param \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToLocaleFacadeInterface $localeFacade
     * @param \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface $repository
     * @param \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToStoreFacadeInterface $storeFacade
     */
    public function __construct(
        KlettiesConfig $config,
        KlettiesToLocaleFacadeInterface $localeFacade,
        KlettiesRepositoryInterface $repository,
        KlettiesToStoreFacadeInterface $storeFacade
    ) {
        $this->config = $config;
        $this->localeFacade = $localeFacade;
        $this->storeFacade = $storeFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): ?KlettiesOrderTransfer
    {
        $klettiesItems = $this->resolveKlettiesItems($quoteTransfer);

        if (count($klettiesItems) === 0) {
            return null;
        }

        $klettiesOrder = new KlettiesOrderTransfer();
        foreach ($klettiesItems as $itemTransfer) {
            $klettiesOrder->addVendorItem($itemTransfer);
        }
        $klettiesOrder->setStore($this->storeFacade->getCurrentStoreName());

        return $klettiesOrder;
    }

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function fromSavedOrder(
        SaveOrderTransfer $saveOrderTransfer,
        KlettiesOrderTransfer $klettiesOrderTransfer
    ): KlettiesOrderTransfer {
        $klettiesOrderTransfer
            ->setOrderReference($saveOrderTransfer->getOrderReference())
            ->setStore($this->storeFacade->getCurrentStoreName())
            ->setIdSalesOrder($saveOrderTransfer->getIdSalesOrder());

        return $klettiesOrderTransfer;
    }

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function fromEntity(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer
    {
        return $this->repository->convertOrderEntityToTransfer($klettiesOrder);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<\Generated\Shared\Transfer\KlettiesOrderItemTransfer>
     */
    protected function resolveKlettiesItems(QuoteTransfer $quoteTransfer): array
    {
        $klettiesItems = [];
        $knownVendor = $this->config->getKnownVendor();
        $currentLocale = $this->localeFacade->getCurrentLocaleName();
        foreach ($this->groupItems($quoteTransfer->getItems()) as $itemTransfer) {
            $attributes = $itemTransfer->getAbstractAttributes();

            if (array_key_exists($currentLocale, $attributes)) {
                $klettiesItems = $this->getItemFromAttributes(
                    $attributes[$currentLocale],
                    $knownVendor,
                    $klettiesItems,
                    $itemTransfer,
                );
            }
            if (array_key_exists(static::FALLBACK_LOCALE, $attributes)) {
                $klettiesItems = $this->getItemFromAttributes(
                    $attributes[static::FALLBACK_LOCALE],
                    $knownVendor,
                    $klettiesItems,
                    $itemTransfer,
                );
            }
        }

        return $klettiesItems;
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ItemTransfer> $items
     *
     * @return array<\Generated\Shared\Transfer\ItemTransfer>
     */
    protected function groupItems(ArrayObject $items): array
    {
        /** @var array<\Generated\Shared\Transfer\ItemTransfer> $groupedItems */
        $groupedItems = [];
        foreach ($items as $itemTransfer) {
            $sku = $itemTransfer->getSku();
            if (array_key_exists($sku, $groupedItems)) {
                $groupedItems[$sku]->setQuantity($itemTransfer->getQuantity() + $groupedItems[$sku]->getQuantity());

                continue;
            }

            $groupedItems[$sku] = clone $itemTransfer;
        }

        return $groupedItems;
    }

    /**
     * @param string $vendorName
     *
     * @return \Generated\Shared\Transfer\KlettiesVendorTransfer
     */
    protected function mapVendor(string $vendorName): KlettiesVendorTransfer
    {
        return (new KlettiesVendorTransfer())
            ->setName($vendorName);
    }

    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    protected function stringEndsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);
        if ($length === 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * @param string $value
     * @param string $vendor
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderItemTransfer
     */
    protected function mapOrderItem(
        string $value,
        string $vendor,
        ItemTransfer $itemTransfer
    ): KlettiesOrderItemTransfer {
        return (new KlettiesOrderItemTransfer())
            ->setSku($value)
            ->setQty($itemTransfer->getQuantity())
            ->setShopSku($itemTransfer->getSku())
            ->setVendor($this->mapVendor($vendor))
            ->setPrintjobId($itemTransfer->getPrintjobId());
    }

    /**
     * @param array $attributes
     * @param array $knownVendor
     * @param array $klettiesItems
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return array
     */
    protected function getItemFromAttributes(
        array $attributes,
        array $knownVendor,
        array $klettiesItems,
        ItemTransfer $itemTransfer
    ): array {
        foreach ($attributes as $attributeName => $attributeValue) {
            if (
                $attributeValue !== null
                && $attributeValue !== ''
                && $this->stringEndsWith(
                    $attributeName,
                    $this->config->getAttributeSkuSuffix(),
                ) && in_array(
                    str_replace($this->config->getAttributeSkuSuffix(), '', $attributeName),
                    $knownVendor,
                    true,
                )
            ) {
                $check = sprintf('%s|%s', $itemTransfer->getFkSalesOrderItem(), $attributeValue);
                if (array_key_exists($check, $klettiesItems) === true) {
                    return $klettiesItems;
                }

                $vendor = str_replace($this->config->getAttributeSkuSuffix(), '', $attributeName);
                $klettiesItems[$check] = $this->mapOrderItem($attributeValue, $vendor, $itemTransfer);

                return $klettiesItems;
            }
        }

        return $klettiesItems;
    }
}
