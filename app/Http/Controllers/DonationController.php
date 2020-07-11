<?php

namespace App\Http\Controllers;

use App\Services\DonationService;

class DonationController extends Controller
{
    /**
     * @var DonationService
     */
    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    public function index()
    {
        $donations = $this->donationService->getList();
        return view('payment.donations', compact('donations'));
    }
}
