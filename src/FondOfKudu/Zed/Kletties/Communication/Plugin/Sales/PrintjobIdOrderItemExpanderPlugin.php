<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\Sales;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderItemExpanderPluginInterface;

/**
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 */
class PrintjobIdOrderItemExpanderPlugin extends AbstractPlugin implements OrderItemExpanderPluginInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<\Generated\Shared\Transfer\ItemTransfer>
     */
    public function expand(array $itemTransfers): array
    {
        return $this->getFacade()->expandOrderItemsWithPrintjobId($itemTransfers);
    }
}
