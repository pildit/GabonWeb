<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GenTux\Jwt\GetsJwtToken;
use DB;
use Log;

class MenuController extends Controller
{
    use GetsJwtToken;

    /**
     * Returns the navigation menu
     */
    public function index()
    {
        $user_roles = [];

        if ($this->getToken()) {
            $user_roles = $this->jwtPayload('data')['roles'];
        }

        if (empty($user_roles)) {
            $user_roles = ['guest'];
        }

        $query =
            '   SELECT menu.id, menu.menu, menu.submenu, menu.page_id, position, pages.path
                FROM admin.menu menu
                LEFT OUTER JOIN admin.pages pages
                ON pages.id = menu.page_id
                WHERE EXISTS (
                        SELECT page_role.id
                              FROM admin.page_role, admin.roles
                              WHERE ( position(roles.name IN  ?) > 0
                    AND (page_role.page_id = pages.id)
                    AND (page_role.role_id = roles.id) )
                              )
                OR position(\'admin\' IN ?) > 0
                ORDER BY position ';

        $user_roles_str  = implode(',', $user_roles);

        $results = DB::select($query, [$user_roles_str, $user_roles_str]);

        $json_response = [];

        foreach ($results as $row) {
            if ($row->menu != '') {
                $json_response[$row->position] = $row;
            } elseif ($row->submenu != '') {
                list($parent, $position) = explode('.', $row->position);
                $json_response[$parent]->children[] = $row;
            }
        }

        return response()->json([
            'data' => array_values($json_response)
        ]);
    }

}
