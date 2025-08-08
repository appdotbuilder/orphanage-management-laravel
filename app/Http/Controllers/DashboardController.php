<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Donation;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('view_dashboard')) {
            abort(403, 'Unauthorized');
        }

        // Get user's primary role
        $userRole = 'guest';
        $roles = $user->roles()->get();
        if ($roles->isNotEmpty()) {
            /** @var Role $firstRole */
            $firstRole = $roles->first();
            $userRole = $firstRole->name;
        }

        // Initialize default values
        $stats = [
            'totalChildren' => 0,
            'activeChildren' => 0,
            'totalDonations' => 0,
            'totalDonationAmount' => 0,
        ];

        $recentChildren = [];
        $recentDonations = [];

        // Role-based data access
        if ($user->hasAnyRole(['admin', 'pengurus'])) {
            // Full access to all data
            $stats = [
                'totalChildren' => Child::count(),
                'activeChildren' => Child::where('status', 'aktif')->count(),
                'totalDonations' => Donation::count(),
                'totalDonationAmount' => Donation::received()->sum('amount'),
            ];

            // Get recent children
            $recentChildren = Child::select(['id', 'name', 'birth_date', 'education_level', 'entry_date'])
                ->latest('entry_date')
                ->take(5)
                ->get()
                ->map(function (Child $child) {
                    $entryDateString = '';
                    if ($child->entry_date) {
                        try {
                            $entryDateString = Carbon::parse($child->entry_date)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $entryDateString = (string) $child->entry_date;
                        }
                    }
                    
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'age' => $child->age,
                        'education_level' => $child->education_level ?? '',
                        'entry_date' => $entryDateString,
                    ];
                })
                ->toArray();

            // Get recent donations
            $recentDonations = Donation::with(['user:id,name'])
                ->latest('donation_date')
                ->take(5)
                ->get()
                ->map(function (Donation $donation) {
                    $donationDateString = '';
                    if ($donation->donation_date) {
                        try {
                            $donationDateString = Carbon::parse($donation->donation_date)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $donationDateString = (string) $donation->donation_date;
                        }
                    }
                    
                    return [
                        'id' => $donation->id,
                        'user' => ['name' => $donation->user->name ?? 'Unknown'],
                        'amount' => $donation->amount,
                        'type' => $donation->getTypeDisplayAttribute(),
                        'donation_date' => $donationDateString,
                    ];
                })
                ->toArray();
        } 
        elseif ($user->hasRole('donatur')) {
            // Limited access for donors
            $stats = [
                'totalChildren' => Child::where('status', 'aktif')->count(),
                'activeChildren' => Child::where('status', 'aktif')->count(),
                'totalDonations' => Donation::where('user_id', $user->id)->count(),
                'totalDonationAmount' => Donation::where('user_id', $user->id)->sum('amount'),
            ];

            $recentChildren = Child::where('status', 'aktif')
                ->select(['id', 'name', 'birth_date', 'education_level', 'entry_date'])
                ->latest('entry_date')
                ->take(5)
                ->get()
                ->map(function (Child $child) {
                    $entryDateString = '';
                    if ($child->entry_date) {
                        try {
                            $entryDateString = Carbon::parse($child->entry_date)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $entryDateString = (string) $child->entry_date;
                        }
                    }
                    
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'age' => $child->age,
                        'education_level' => $child->education_level ?? '',
                        'entry_date' => $entryDateString,
                    ];
                })
                ->toArray();

            $recentDonations = Donation::where('user_id', $user->id)
                ->latest('donation_date')
                ->take(5)
                ->get()
                ->map(function (Donation $donation) use ($user) {
                    $donationDateString = '';
                    if ($donation->donation_date) {
                        try {
                            $donationDateString = Carbon::parse($donation->donation_date)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $donationDateString = (string) $donation->donation_date;
                        }
                    }
                    
                    return [
                        'id' => $donation->id,
                        'user' => ['name' => $user->name],
                        'amount' => $donation->amount,
                        'type' => $donation->getTypeDisplayAttribute(),
                        'donation_date' => $donationDateString,
                    ];
                })
                ->toArray();
        }
        elseif ($user->hasRole('anak')) {
            // Very limited access for children
            $stats = [
                'totalChildren' => 0,
                'activeChildren' => 0,
                'totalDonations' => Donation::where('child_id', $user->id)->count(),
                'totalDonationAmount' => Donation::where('child_id', $user->id)->sum('amount'),
            ];

            $recentDonations = Donation::with(['user:id,name'])
                ->where('child_id', $user->id)
                ->latest('donation_date')
                ->take(5)
                ->get()
                ->map(function (Donation $donation) {
                    $donationDateString = '';
                    if ($donation->donation_date) {
                        try {
                            $donationDateString = Carbon::parse($donation->donation_date)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $donationDateString = (string) $donation->donation_date;
                        }
                    }
                    
                    return [
                        'id' => $donation->id,
                        'user' => ['name' => $donation->user->name ?? 'Unknown'],
                        'amount' => $donation->amount,
                        'type' => $donation->getTypeDisplayAttribute(),
                        'donation_date' => $donationDateString,
                    ];
                })
                ->toArray();
        }

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recentChildren' => $recentChildren,
            'recentDonations' => $recentDonations,
            'userRole' => $userRole,
        ]);
    }
}