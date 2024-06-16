<?php

namespace App\Http\Controllers\Admin\Cost;

use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CostEmployeeSearchController extends Controller
{
use ApiResponse;
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $employeePhone = $request->employeePhone;
            $employee = Employee::query()
                            ->filterByPhone($employeePhone)
                            ->select(['id','name'])
                            ->first();
            if (!isset($employee)) {
                return $this->respondSuccess(null,'Not Employee');
            }
            return $this->respondSuccess($employee, 'Employee fetched successfully');
        } catch (\Throwable $exception) {
            return $this->respondError('Something went wrong');
        }
    }
}
