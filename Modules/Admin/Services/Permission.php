<?php


namespace Modules\Admin\Services;


use App\Services\PageResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\PageRole;
use Modules\Admin\Entities\Permission as PermissionEntity;
use Modules\Admin\Entities\Role;

class Permission extends PageResults
{
    public function getPaginator()
    {
        $this->query = PermissionEntity::ofSort($this->getSortCriteria());

        return $this->setFilters(['name'])->getResults();
    }

    public function getRolePagePaginator($role)
    {
        $this->query = PageRole::with(['role.permissions', 'page'])->where(['role_id' => $role->id]);

        return $this->getResults();
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function storeTransaction(Request $request): void
    {
        DB::beginTransaction();

        try {

            $page = Page::find($request->get('page_id'));
            $role = Role::find($request->get('role_id'));

            PageRole::create([
                'page_id' => $request->get('page_id'), 'role_id' => $request->get('role_id')
            ]);

            foreach ($request->get('can') as $can) {
                $permission = new PermissionEntity();
                $permission->name = $page->resource . "." . $can;
                $permission->save();
                $permission->assignRole($role);
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param Role $role
     * @param $permissions
     * @throws \Exception
     */
    public function updateTransaction(Request $request, Role $role): void
    {
        DB::beginTransaction();

        try {
            $page = Page::find($request->get('page_id'));

            PageRole::firstOrCreate([
                'page_id' => $request->get('page_id'), 'role_id' => $role->id
            ]);

            $permissions = [];
            foreach ($request->get('can') as $k => $can) {
                $permissionName = $page->resource . "." . $can;
                $permissions[$k] = PermissionEntity::firstOrNew(['name' => $permissionName]);
                $permissions[$k]->save();
            }

            //TODO find a way to sync permissions of a resource to roles
            $rolePermissions = $role->getPermissionNames()->filter(function ($permission) use ($page) {
                return !\Str::startsWith($permission, $page->resource);
                return !\Str::startsWith($permission, $page->resource);
            });
            $syncPermissions = collect($permissions)->pluck('name')->merge($rolePermissions);
            $role->syncPermissions($syncPermissions);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
