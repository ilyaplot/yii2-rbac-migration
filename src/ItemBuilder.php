<?php
namespace ErickSkrauch\Yii2;

use yii\rbac\Item;
use yii\rbac\ManagerInterface;
use yii\rbac\Permission;
use yii\rbac\Role;

class ItemBuilder
{
    /**
     * @var ManagerInterface
     */
    private $authManager;

    /**
     * @var Item
     */
    private $item;

    public function __construct(ManagerInterface $authManager, Item $item)
    {
        $this->authManager = $authManager;
        $this->item = $item;
    }

    /**
     * @return ManagerInterface
     */
    public function getAuthManager()
    {
        return $this->authManager;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param string|Permission $permission
     * @return static
     */
    public function addPermission($permission)
    {
        $permission = $this->findPermission($permission);
        $this->authManager->addChild($this->item, $permission);

        return $this;
    }

    /**
     * @param string|Role $role
     * @return static
     */
    public function addRole($role)
    {
        $role = $this->findRole($role);
        $this->authManager->addChild($this->item, $role);

        return $this;
    }

    /**
     * @param string|Permission $permission
     * @return static
     */
    public function removePermission($permission)
    {
        $permission = $this->findPermission($permission);
        $this->authManager->removeChild($this->item, $permission);

        return $this;
    }

    /**
     * @param string|Role $role
     * @return static
     */
    public function removeRole($role)
    {
        $role = $this->findRole($role);
        $this->authManager->removeChild($this->item, $role);

        return $this;
    }

    /**
     * @param string|Permission $permission
     * @return Permission
     */
    protected function findPermission($permission)
    {
        if ($permission instanceof Permission) {
            return $permission;
        }

        return $this->authManager->getPermission($permission);
    }

    /**
     * @param string|Role $role
     * @return Role
     */
    protected function findRole($role)
    {
        if ($role instanceof Role) {
            return $role;
        }

        return $this->authManager->getRole($role);
    }

}
