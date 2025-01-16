<?php

namespace FondOfKudu\Zed\Kletties\Business\Expander;

interface OrderItemPrintjobIdExpanderInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<\Generated\Shared\Transfer\ItemTransfer>
     */
    public function expandOrderItemsWithPrintjobId(array $itemTransfers): array;
}
