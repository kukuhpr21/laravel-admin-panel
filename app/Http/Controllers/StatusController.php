<?php

namespace App\Http\Controllers;

use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use App\Services\StatusService;
use App\DataTables\StatusDataTable;
use App\Http\Requests\StoreStatusRequest;
use App\DataTransferObjects\Status\StoreStatusDto;

class StatusController extends Controller
{
    use ResponseUtils;

    private StatusService $statusService;

    public function __construct(StatusService $statusService) {
        $this->statusService = $statusService;
    }
    public function index(StatusDataTable $dataTable)
    {
        return $dataTable->render('pages.app.settings.statuses.list');
    }

    public function create()
    {
        return view('pages.app.settings.statuses.create');
    }

    public function store(StoreStatusRequest $request)
    {
        $response = $this->statusService->store(StoreStatusDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('statuses');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $id       = CryptUtils::dec($id);
        $response = $this->statusService->findOne($id);
        $data     = json_decode($response['data']);
        $data->id = CryptUtils::enc($data->id);
        return view('pages.app.settings.statuses.edit', compact('data'));
    }

    public function update($id, StoreStatusRequest $request)
    {
        $id       = CryptUtils::dec($id);
        $name     = StoreStatusDto::fromRequest($request)->name;
        $response = $this->statusService->update($id, $name);
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('statuses');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $id       = CryptUtils::dec($id);
        $response = $this->statusService->delete($id);
        ResponseUtils::showToast($response);
        return redirect()->route('statuses');
    }
}
