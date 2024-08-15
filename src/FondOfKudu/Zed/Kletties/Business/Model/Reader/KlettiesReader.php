<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Reader;

use FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;

class KlettiesReader implements KlettiesReaderInterface
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface
     */
    protected KlettiesRepositoryInterface $repository;

    /**
     * @param \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface $repository
     */
    public function __construct(KlettiesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByOrderReference(string $orderReference): ?KlettiesOrderTransfer
    {
        return $this->repository->findKlettiesOrderByKlettiesReference($orderReference);
    }

    /**
     * @param string $klettiesReference
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByKlettiesReference(string $klettiesReference): ?KlettiesOrderTransfer
    {
        return $this->repository->findKlettiesOrderByOrderReference($klettiesReference);
    }

    /**
     * @param int $id
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderById(int $id): ?KlettiesOrderTransfer
    {
        return $this->repository->findKlettiesOrderById($id);
    }
}
