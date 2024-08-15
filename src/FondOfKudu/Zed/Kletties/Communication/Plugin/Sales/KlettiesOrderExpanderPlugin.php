<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\Sales;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface;

/**
 * Class KlettiesOrderExpanderPlugin
 *
 * @package FondOfKudu\Zed\Kletties\Communication\Plugin\Sales
 *
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 */
class KlettiesOrderExpanderPlugin extends AbstractPlugin implements OrderExpanderPreSavePluginInterface
{
    /**
     * Specification:
     *   - It's a plugin which hydrates SpySalesOrderEntityTransfer before order created
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\SpySalesOrderEntityTransfer
     */
    public function expand(
        SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer,
        QuoteTransfer $quoteTransfer
    ): SpySalesOrderEntityTransfer {
        $quoteTransfer = $this->getFacade()->createKlettiesOrderFromQuote($quoteTransfer);
        $klettiesOrder = $quoteTransfer->getKlettiesOrder();

        if ($klettiesOrder !== null) {
            $spySalesOrderEntityTransfer->setFkFokKlettiesOrder($klettiesOrder->getId());
        }

        return $spySalesOrderEntityTransfer;
    }
}
