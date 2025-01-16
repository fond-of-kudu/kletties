<?php

namespace FondOfKudu\Zed\Kletties\Business\Expander;

use FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface;

class OrderItemPrintjobIdExpander implements OrderItemPrintjobIdExpanderInterface
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface
     */
    protected KlettiesRepositoryInterface $klettiesRepository;

    /**
     * @param \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface $klettiesRepository
     */
    public function __construct(KlettiesRepositoryInterface $klettiesRepository)
    {
        $this->klettiesRepository = $klettiesRepository;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<\Generated\Shared\Transfer\ItemTransfer>
     */
    public function expandOrderItemsWithPrintjobId(array $itemTransfers): array
    {
        foreach ($itemTransfers as $itemTransfer) {
            $klettiesOrderItemTransfer = $this->klettiesRepository
                ->findKlettiesOrderItemByShopSku($itemTransfer->getGroupKey());

            if ($klettiesOrderItemTransfer === null || !$klettiesOrderItemTransfer->getPrintjobId()) {
                continue;
            }

            $itemTransfer->setPrintjobId($klettiesOrderItemTransfer->getPrintjobId());
        }

        return $itemTransfers;
    }
}
