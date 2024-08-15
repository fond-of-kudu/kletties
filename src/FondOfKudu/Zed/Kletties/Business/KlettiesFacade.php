<?php

namespace FondOfKudu\Zed\Kletties\Business;

use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * Class KlettiesFacade
 *
 * @package FondOfKudu\Zed\Kletties\Business
 *
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesBusinessFactory getFactory()
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManagerInterface getEntityManager()
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface getRepository()
 */
class KlettiesFacade extends AbstractFacade implements KlettiesFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function createKlettiesOrderFromQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()->createKlettiesOrderHandler()->handleFromQuote($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function addAndSaveOrderDataFromSaveOrderTransfer(
        SaveOrderTransfer $saveOrderTransfer,
        KlettiesOrderTransfer $klettiesOrderTransfer
    ): KlettiesOrderTransfer {
        return $this->getFactory()->createKlettiesOrderHandler()->handleFromSavedOrder(
            $saveOrderTransfer,
            $klettiesOrderTransfer,
        );
    }

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function convertKlettiesOrderEntityToTransfer(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer
    {
        return $this->getFactory()->createKlettiesOrderMapper()->fromEntity($klettiesOrder);
    }

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByOrderReference(string $orderReference): ?KlettiesOrderTransfer
    {
        return $this->getFactory()->createKlettiesReader()->findKlettiesOrderByOrderReference($orderReference);
    }

    /**
     * @param string $klettiesReference
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByKlettiesReference(string $klettiesReference): ?KlettiesOrderTransfer
    {
        return $this->getFactory()->createKlettiesReader()->findKlettiesOrderByKlettiesReference($klettiesReference);
    }

    /**
     * @param int $id
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderById(int $id): ?KlettiesOrderTransfer
    {
        return $this->getFactory()->createKlettiesReader()->findKlettiesOrderById($id);
    }

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function updateKlettiesOrder(KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer
    {
        return $this->getFactory()->createKlettiesOrderWriter()->update($klettiesOrderTransfer);
    }
}
