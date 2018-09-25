<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRole\Communication\Plugin\CompanyUser;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface getFacade()
 * @method \Spryker\Zed\CompanyRole\CompanyRoleConfig getConfig()
 */
class AssignDefaultCompanyUserRolePlugin extends AbstractPlugin implements CompanyUserPostCreatePluginInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function postCreate(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        return $this->assignDefaultRoleToCompanyUser($companyUserResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected function assignDefaultRoleToCompanyUser(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        if (!$companyUserResponseTransfer->getCompanyUser() || $companyUserResponseTransfer->getCompanyUser()->getFkCompany()) {
            return $companyUserResponseTransfer->setIsSuccessful(false);
        }

        $defaultCompanyRoleTransfer = $this->getFacade()->findDefaultCompanyRoleByIdCompany(
            $companyUserResponseTransfer->getCompanyUser()->getFkCompany()
        );

        if (!$defaultCompanyRoleTransfer) {
            return $companyUserResponseTransfer->setIsSuccessful(false);
        }

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if (!$companyUserTransfer->getCompanyRoleCollection()) {
            $companyUserTransfer->setCompanyRoleCollection(new CompanyRoleCollectionTransfer());
        }

        $companyUserTransfer->getCompanyRoleCollection()->addRole($defaultCompanyRoleTransfer);

        $this->getFacade()->saveCompanyUser($companyUserTransfer);

        return $companyUserResponseTransfer;
    }
}
