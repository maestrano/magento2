<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tax\Controller\Adminhtml\Rate;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Tax\Controller\Adminhtml\Rate
{
    /**
     * Delete Rate and Data
     *
     * @return \Magento\Backend\Model\View\Result\Redirect|void
     */
    public function execute()
    {
        if ($rateId = $this->getRequest()->getParam('rate')) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            try {
                $this->_taxRateRepository->deleteById($rateId);

                $this->messageManager->addSuccess(__('The tax rate has been deleted.'));
                return $resultRedirect->setPath("*/*/");
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(
                    __('Something went wrong deleting this rate because of an incorrect rate ID.')
                );
                return $resultRedirect->setPath("tax/*/");
            }
        }
    }

    /**
     * @inheritdoc
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function getDefaultResult()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if ($this->getRequest()->getServer('HTTP_REFERER')) {
            $resultRedirect->setRefererUrl();
        } else {
            $resultRedirect->setPath("*/*/");
        }
        return $resultRedirect;
    }
}
