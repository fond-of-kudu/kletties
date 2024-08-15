<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\Sales;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderPostSavePluginInterface;

/**
 * Class UpdateKlettiesOrderAfterPostSaveOrderExpanderPlugin
 *
 * @package FondOfKudu\Zed\Kletties\Communication\Plugin\Sales
 *
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 */
class PatchKlettiesOrderAfterSalesOrderWasSavedOrderPostSavePlugin extends AbstractPlugin implements OrderPostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function execute(SaveOrderTransfer $saveOrderTransfer, QuoteTransfer $quoteTransfer): SaveOrderTransfer
    {
        $klettiesOrder = $quoteTransfer->getKlettiesOrder();
        if ($klettiesOrder !== null) {
            $this->getFacade()->addAndSaveOrderDataFromSaveOrderTransfer($saveOrderTransfer, $klettiesOrder);
        }

        return $saveOrderTransfer;
    }
}
