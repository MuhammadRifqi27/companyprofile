<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\OurTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OurTeamController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teams = OurTeam::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('occupation', 'like', "%$search%")
                         ->orWhere('location', 'like', "%$search%");
        })->orderByDesc('id')->paginate(10);

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(StoreTeamRequest $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $validated = $request->validated();

                if ($request->hasFile('avatar')) {
                    $avatarPath = $request->file('avatar')->store('avatars', 'public');
                }

                OurTeam::create($validated);
            });

            return redirect()->route('admin.teams.index')->with('success', 'Team added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the team member.');
        }
    }

    public function show(OurTeam $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    public function edit(OurTeam $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(StoreTeamRequest $request, OurTeam $team)
    {
        try {
            DB::transaction(function() use ($request, $team) {
                $validated = $request->validated();
    
                if ($request->hasFile('avatar')) {
                    $avatarPath = $request->file('avatar')->store('avatars', 'public');
                    $validated['avatar'] = $avatarPath;
                }
    
                $team->update($validated);
            });
    
            return redirect()->route('admin.teams.index')->with('success', 'Team member updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the team member.');
        }
    }

    public function destroy(OurTeam $team)
    {
        try {
            DB::transaction(function() use ($team) {
                $team->delete();
            });

            return redirect()->route('admin.teams.index')->with('success', 'Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the team member.');
        }
    }
}