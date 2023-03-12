<?php declare(strict_types=1);
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to mario@raval.li so I can send you a copy immediately.
 *
 * @author    Mario Ravalli <mario@raval.li>
 * @copyright Since 2023 Mario Ravalli
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace MyModule\Controller\Admin;

use Doctrine\Common\Cache\CacheProvider;
use PrestaShopBundle\Security\Annotation\ModuleActivated;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;

/**
 * Class BoilerController.
 *
 * @ModuleActivated(moduleName="mymodule", redirectRoute="admin_module_manage")
 */
class BoilerController extends FrameworkBundleAdminController
{
    private CacheProvider $cache;

    public function __construct(CacheProvider $cache)
    {
        $this->cache = $cache;
        parent::__construct();
    }

    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @return Response
     */
    public function bookingAction()
    {
        return $this->render('@Modules/mymodule/views/templates/admin/boilerplate.html.twig');
    }
}