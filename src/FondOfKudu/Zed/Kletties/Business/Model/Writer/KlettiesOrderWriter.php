<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Writer;

use FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManagerInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;

class KlettiesOrderWriter implements KlettiesOrderWriterInterface
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManagerInterface
     */
    protected KlettiesEntityManagerInterface $entityManager;

    /**
     * @param \FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManagerInterface $entityManager
     */
    public function __construct(KlettiesEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function create(KlettiesOrderTransfer $orderTransfer): KlettiesOrderTransfer
    {
        return $this->entityManager->createKlettiesOrder($orderTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function update(KlettiesOrderTransfer $orderTransfer): KlettiesOrderTransfer
    {
        return $this->entityManager->updateKlettiesOrder($orderTransfer);
    }
}
