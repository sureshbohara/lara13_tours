<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SettingRequest;
use App\Services\Admin\SettingService;

class SettingController extends BaseController
{
  
    public function __construct(protected SettingService $service)
    {
        //
    }

 
    public function index(){
        return view('admin.settings.index', [
            'setting' => $this->service->getSettings(),
        ]);
    }


    public function update(SettingRequest $request){
        $this->service->updateSettings($request->validated());

        return $this->successJson('Settings updated successfully!');
    }
}