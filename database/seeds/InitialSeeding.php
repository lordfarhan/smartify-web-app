<?php

use App\Institution;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InitialSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Institution::create([
            'name' => 'Codeiva',
            'description' => 'This institution is only for codeiva member'
        ]);
        Institution::create([
            'name' => 'Smartify',
            'description' => 'This institution is for public and non-partnership users'
        ]);

        $permissions = [
            'institution-list',
            'institution-create',
            'institution-edit',
            'institution-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'subject-list',
            'subject-create',
            'subject-edit',
            'subject-delete',
            'grade-list',
            'grade-create',
            'grade-edit',
            'grade-delete',
            'course-list',
            'course-create',
            'course-edit',
            'course-delete',
            'chapter-list',
            'chapter-create',
            'chapter-edit',
            'chapter-delete',
            'sub-chapter-list',
            'sub-chapter-create',
            'sub-chapter-edit',
            'sub-chapter-delete',
            'schedule-list',
            'schedule-create',
            'schedule-edit',
            'schedule-delete',
            'test-list',
            'test-create',
            'test-edit',
            'test-delete',
            'question-list',
            'question-create',
            'question-edit',
            'question-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $user = User::create([
            'name' => 'Lord Farhan', 
            'institution_id' => 1,
            'email' => 'farhan@codeiva.com',
            'password' => bcrypt('farhan123'),
            'active' => '1'
        ]);

        $role = Role::create(['name' => 'Master']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
