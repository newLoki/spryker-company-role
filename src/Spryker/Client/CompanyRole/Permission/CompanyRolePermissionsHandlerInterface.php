<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CompanyRole\Permission;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;

interface CompanyRolePermissionsHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $companyRolePermissions
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function filterCompanyRolePermissions(
        CompanyRoleTransfer $companyRoleTransfer,
        PermissionCollectionTransfer $companyRolePermissions
    ): PermissionCollectionTransfer;
}
