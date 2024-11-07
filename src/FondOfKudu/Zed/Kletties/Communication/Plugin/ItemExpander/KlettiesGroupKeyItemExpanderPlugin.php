<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\ItemExpander;

use Generated\Shared\Transfer\CartChangeTransfer;
use Spryker\Zed\CartExtension\Dependency\Plugin\ItemExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 */
class KlettiesGroupKeyItemExpanderPlugin extends AbstractPlugin implements ItemExpanderPluginInterface
{
    /**
     * @var string
     */
    protected const PATTERN_GROUP_KEY = '%s-printjobid-%s';

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        foreach ($cartChangeTransfer->getItems() as $itemTransfer) {
            if (!$itemTransfer->getPrintjobId()) {
                continue;
            }

            $itemTransfer->setGroupKey(
                sprintf(
                    static::PATTERN_GROUP_KEY,
                    $itemTransfer->getGroupKey(),
                    $itemTransfer->getPrintjobId(),
                ),
            );
        }

        return $cartChangeTransfer;
    }
}
