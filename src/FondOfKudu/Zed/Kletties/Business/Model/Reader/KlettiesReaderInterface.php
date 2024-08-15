<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Reader;

use Generated\Shared\Transfer\KlettiesOrderTransfer;

interface KlettiesReaderInterface
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
}
