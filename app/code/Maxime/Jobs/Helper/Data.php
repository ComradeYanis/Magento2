<?php

namespace Maxime\Jobs\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Maxime\Jobs\Helper
 */
class Data extends AbstractHelper
{

    /**
     * @const LIST_JOBS_ENABLED
     */
    const LIST_JOBS_ENABLED = 'jobs/department/view_list';

    public function getListJobEnabled()
    {
        return $this->scopeConfig->getValue(
            self::LIST_JOBS_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
}
