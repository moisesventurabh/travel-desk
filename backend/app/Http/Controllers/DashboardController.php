<?php

namespace App\Http\Controllers;

use App\Services\ViagensService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $viagensService;

    public function __construct(ViagensService $viagensService)
    {
        $this->viagensService = $viagensService;
    }

    public function index()
    {
        $stats = $this->viagensService->getStats();
        $viagens = $this->viagensService->getRecent(8);

        return view('admin.dashboard', compact('stats', 'viagens'));
    }
}