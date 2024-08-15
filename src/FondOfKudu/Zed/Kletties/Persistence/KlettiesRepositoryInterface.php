<?php

namespace FondOfKudu\Zed\Kletties\Persistence;

use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;

interface KlettiesRepositoryInterface
{
    /**
     * @param string $orderReference
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByOrderReference(string $orderReference): ?KlettiesOrderTransfer;

    /**
     * @param string $klettiesReference
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByKlettiesReference(string $klettiesReference): ?KlettiesOrderTransfer;

    /**
     * @param int $id
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderById(int $id): ?KlettiesOrderTransfer;

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function convertOrderEntityToTransfer(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer;
}
