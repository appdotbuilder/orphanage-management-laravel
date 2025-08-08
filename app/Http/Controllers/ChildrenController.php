<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildRequest;
use App\Http\Requests\UpdateChildRequest;
use App\Models\Child;
use Inertia\Inertia;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Check permissions based on role
        if (!$user->hasPermission('view_children')) {
            abort(403, 'Unauthorized');
        }

        $query = Child::query()->with('donations');

        // Apply filters based on user role
        if ($user->hasRole('donatur')) {
            // Donatur can only see basic info of active children
            $query->where('status', 'aktif')
                  ->select(['id', 'name', 'nickname', 'birth_date', 'gender', 'photo_url', 'education_level', 'school_name']);
        }

        $children = $query->latest()->paginate(12);
        
        return Inertia::render('children/index', [
            'children' => $children,
            'can' => [
                'create' => $user->hasPermission('create_children'),
                'update' => $user->hasPermission('update_children'),
                'delete' => $user->hasPermission('delete_children'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('create_children')) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('children/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildRequest $request)
    {
        $child = Child::create($request->validated());

        return redirect()->route('children.show', $child)
            ->with('success', 'Data anak berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Child $child)
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('view_children')) {
            abort(403, 'Unauthorized');
        }

        // Load relationships based on user role
        $child->load(['donations.user']);

        // Filter sensitive data for donatur role
        if ($user->hasRole('donatur')) {
            $child->makeHidden(['background_story', 'health_condition', 'special_needs', 'notes']);
        }

        return Inertia::render('children/show', [
            'child' => $child,
            'can' => [
                'update' => $user->hasPermission('update_children'),
                'delete' => $user->hasPermission('delete_children'),
                'donate' => $user->hasPermission('create_donations'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Child $child)
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('update_children')) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('children/edit', [
            'child' => $child
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildRequest $request, Child $child)
    {
        $child->update($request->validated());

        return redirect()->route('children.show', $child)
            ->with('success', 'Data anak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Child $child)
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('delete_children')) {
            abort(403, 'Unauthorized');
        }

        $child->delete();

        return redirect()->route('children.index')
            ->with('success', 'Data anak berhasil dihapus.');
    }
}