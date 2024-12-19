<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;
use App\Services\MenuService;
use App\DataTables\MenusDataTable;
use App\Http\Requests\MenuPostRequest;
use App\DataTransferObjects\Menu\MenuPostDto;

class MenuController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private MenuService $menuService;

    public function __construct(MenuService $menuService) {
        $this->menuService = $menuService;
    }

    public function index(MenusDataTable $dataTable)
    {
        return $dataTable->render('pages.app.menus.list');
    }

    public function create()
    {
        $mapParent = ['id' => 'value', 'name' => 'text'];
        $allParent = $this->menuService->findAllParent()['data'];
        $parents   = [];
        array_push($parents, ['value' => '#', 'text' => 'Default Parent']);
        $parent_transform = ArrayUtils::transform($allParent, $mapParent);

        foreach ($parent_transform as $item) {
            array_push($parents, $item);
        }

        // tree menu
        $menus = $this->menuService->findAll(true)['data'];
        $menus = $this->menuService->makeHTMLMenu($menus);
        return view('pages.app.menus.create', compact('parents', 'menus'));
    }

    public function store(MenuPostRequest $request)
    {
        $response = $this->menuService->store(MenuPostDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('menus');
        }
        return redirect()->back();
    }
}
