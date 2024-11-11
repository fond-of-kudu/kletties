<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\Sales;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderItemExpanderPreSavePluginInterface;

/**
 * Class AddKlettiesDataToSalesOrderItemExpanderPreSavePlugin
 *
 * @package FondOfKudu\Zed\Kletties\Communication\Plugin\Sales
 *
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 */
class AddKlettiesDataToSalesOrderItemExpanderPreSavePlugin extends AbstractPlugin implements OrderItemExpanderPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer $salesOrderItemEntity
     *
     * @return \Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer
     */
    public function expandOrderItem(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer,
        SpySalesOrderItemEntityTransfer $salesOrderItemEntity
    ): SpySalesOrderItemEntityTransfer {
        $klettiesOrder = $quoteTransfer->getKlettiesOrder();

        if ($klettiesOrder !== null) {
            foreach ($klettiesOrder->getVendorItems() as $klettiesOrderItemTransfer) {
                if ($salesOrderItemEntity->getGroupKey() === $klettiesOrderItemTransfer->getShopSku()) {
                    $salesOrderItemEntity->setVendor($klettiesOrderItemTransfer->getVendor()->getName());
                    $salesOrderItemEntity->setVendorSku($klettiesOrderItemTransfer->getSku());

                    return $salesOrderItemEntity;
                }
            }
        }

        return $salesOrderItemEntity;
    }
}
