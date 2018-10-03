<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateSprintTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_logged_in_user_can_create_a_sprint()
    {
        // Generate project
        $project = factory(App\Project::class)->create();

        // Login first user
        $user = $this->actingAsUser();

        // Visit page
        $this->visit(route('sprint.create'));

        // Verify correct page loads
        $this->seePageIs(route('sprint.create'));

        // Fill in form an submit
        $this->type('Test sprint', 'name')
            ->select($project->id, 'project_id')
            ->press('Add');

        // Verify success alert shown
        $this->see('alert-success');

        // Verify redirected to correct page
        $this->seePageIs(route('sprint.index'));


        // Verify sprint added to database
        $this->seeInDatabase('sprints', [
            'name' => 'Test sprint',
            'project_id' => $project->id
        ]);
    }
}
