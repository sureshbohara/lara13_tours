<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use App\Services\Admin\SiteHealthService;
use Illuminate\View\View;

class SiteHealthController extends BaseController
{
    public function __construct(private readonly SiteHealthService $siteHealthService) {}

    public function index(): View
    {
        return view('admin.settings.site_health', [
            'serverInfo'       => $this->siteHealthService->getServerInfo(),
            'directories'      => $this->siteHealthService->getDirectorySizes(),
            'siteHealthStatus' => $this->siteHealthService->getSiteHealthStatus(),
            'diskChartData'    => $this->siteHealthService->getDiskSpaceChartData(),
        ]);
    }
}