<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\CartsRestApi;

use Generated\Shared\Transfer\CartItemRequestTransfer;
use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Spryker\Zed\CartsRestApiExtension\Dependency\Plugin\CartItemMapperPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 */
class KlettiesCartItemMapperPlugin extends AbstractPlugin implements CartItemMapperPluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\CartItemRequestTransfer $cartItemRequestTransfer
     * @param \Generated\Shared\Transfer\PersistentCartChangeTransfer $persistentCartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\PersistentCartChangeTransfer
     */
    public function mapCartItemRequestTransferToPersistentCartChangeTransfer(
        CartItemRequestTransfer $cartItemRequestTransfer,
        PersistentCartChangeTransfer $persistentCartChangeTransfer
    ): PersistentCartChangeTransfer {
        foreach ($persistentCartChangeTransfer->getItems() as $itemTransfer) {
            if ($itemTransfer->getSku() !== $cartItemRequestTransfer->getSku()) {
                continue;
            }

            $itemTransfer
                ->setPrintjobId($cartItemRequestTransfer->getPrintjobId())
                ->setPreviewImageUrl($cartItemRequestTransfer->getPreviewImageUrl());
        }

        return $persistentCartChangeTransfer;
    }
}
