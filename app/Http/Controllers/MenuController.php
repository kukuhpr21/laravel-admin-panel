<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\CryptUtils;
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
        $menus    = self::getTreeMenuHtml();
        return $dataTable->render('pages.app.menus.list', compact('menus'));
    }

    public function create()
    {
        $parents = self::getParents();
        $menus   = self::getTreeMenuHtml();
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

    public function edit($id)
    {
        $id       = CryptUtils::dec($id);
        $response = $this->menuService->findOne($id);
        $data     = json_decode($response['data']);
        $data->id = CryptUtils::enc($data->id);
        $parents  = self::getParents();
        $menus    = self::getTreeMenuHtml();
        return view('pages.app.menus.edit', compact('data', 'parents', 'menus'));
    }

    public function update($id, MenuPostRequest $request)
    {
        $id       = CryptUtils::dec($id);
        $response = $this->menuService->update($id, MenuPostDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('menus');
        }
        return redirect()->back();
    }

    private function getParents()
    {
        $mapParent = ['id' => 'value', 'name' => 'text'];
        $allParent = $this->menuService->findAllParent()['data'];
        $parents   = [];
        array_push($parents, ['value' => '#', 'text' => 'Default Parent']);
        $parent_transform = ArrayUtils::transform($allParent, $mapParent);

        foreach ($parent_transform as $item) {
            array_push($parents, $item);
        }
        return $parents;
    }

    private function getTreeMenuHtml()
    {
        $menus = $this->menuService->findAll(true)['data'];
        return $this->menuService->makeHTMLMenu($menus);
    }
}
