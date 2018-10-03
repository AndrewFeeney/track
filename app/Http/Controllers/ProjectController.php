<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project.index', ['projects' => Project::all()]);
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create', ['clients' => Client::all()]);
    }

    /**
     * Store a newly created project in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'client_id' => 'exists:clients,id',
        ]);

        $project = factory(Project::class)->create($request->except('_token'));

        return redirect()
            ->route('project.index')
            ->with(['messages' => [
                        'success' => 'You have created a new project called '.
                        $project->name,
                    ],
                ]
            );
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project \\ The project to be shown
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('project.edit', [
            'project' => $project,
            'clients' => Client::all() 
        ]);
    }

    /**
     * Update the specified project in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'name' => 'required',
            'client_id' => 'exists:clients,id'
        ]);

        $project->update($request->all());

        return redirect()
            ->route('project.index')
            ->with(['messages' => ['success' => 'Project ' . $project->name . ' updated.']]);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('project.index')
            ->with(['messages' => ['success' => 'You have deleted Project '.$project->name.'.']]);
    }
}
