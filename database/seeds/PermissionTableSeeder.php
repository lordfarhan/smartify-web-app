<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
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
            'sub-chapter-delete'
         ];
 
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
