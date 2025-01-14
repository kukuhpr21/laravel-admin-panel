<?php

namespace App\Services\Impl;

use Exception;
use App\Models\User;
use App\Models\Status;
use App\Utils\ResponseUtils;
use App\Services\StatusService;
use App\DataTransferObjects\Status\StoreStatusDto;

class StatusServiceImpl implements StatusService
{
    use ResponseUtils;

    public function store(StoreStatusDto $dto)
    {
        try {
            $status = Status::create([
                'id' => self::getID($dto->name),
                'name' => $dto->name
            ]);

            if ($status) {
                return ResponseUtils::success(
                    message: 'Success create status',
                    data: $status
                );
            }

            return ResponseUtils::failed('Failed create status');

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed create status : '.$errorMessage);
        }

    }

    public function findAll()
    {
        try {
            $statuses = status::all();

            if ($statuses) {
                return ResponseUtils::success('status is exist', $statuses);
            }

            return ResponseUtils::failed('status not found');
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all status : '.$errorMessage);
        }
    }

    public function findOne(string $id)
    {
        try {
            $status = status::where('id', $id)->first();

            if ($status) {
                return ResponseUtils::success('status is exist', $status);
            } else {
                return ResponseUtils::failed('status not found', ['id' => $id]);
            }

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find one status : '.$errorMessage);
        }
    }

    public function update(string $id, string $newName)
    {
        try {
            $newID = self::getID($newName);
            $status = status::where(
                'id',
                $newID
                )
                ->first();

            if (!$status) {
                if ($this->statusIsNotUsed($id)) {

                    $oldStatusIsDeleted = status::where('id', $id)->delete();

                    if ($oldStatusIsDeleted) {

                        $result = status::create([
                            'id' => $newID,
                            'name' => $newName
                        ]);

                        if ($result) {
                            return ResponseUtils::success('Success updating status', $result);
                        }
                    }
                    return ResponseUtils::failed('Failed updating status', "failed delete status in method update status");
                }
                return ResponseUtils::warning('status has been used');
            }

            return ResponseUtils::warning('No data change');
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update status : '.$errorMessage);
        }
    }

    public function delete(string $id)
    {
        try {
            if ($this->statusIsNotUsed($id)) {
                $result = status::where('id', $id)->delete();

                if ($result) {
                    return ResponseUtils::success( 'Success deleting status', $result);
                }
                return ResponseUtils::failed( 'Failed deleting status');
            }
            return ResponseUtils::warning('status has been used');

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete status : '.$errorMessage);
        }
    }
    private static function getID(string $name): string
    {
        return  strtolower(str_replace(" ", "_", $name));
    }

    private function statusIsNotUsed(string $statusID): bool
    {
        $status = User::where('status_id', $statusID)->first();
        return !$status;
    }
}
