<?php

use App\Models\Comment;
use App\Models\MediaLibrary;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        $role_editor = Role::firstOrCreate(['name' => Role::ROLE_EDITOR]);
        $role_admin = Role::firstOrCreate(['name' => Role::ROLE_ADMIN]);

        // MediaLibrary
        MediaLibrary::firstOrCreate([]);

        // Admin User
        $admin_user = User::firstOrCreate(
            ['email' => 'demo@demo.com'],
            [
                'name' => 'anakin',
                'password' => Hash::make('demodemo'),
                'email_verified_at' => now()
            ]
        );

        $admin_user->roles()->sync([$role_admin->id]);

        // Editor User
        $editor_user = User::firstOrCreate(
            ['email' => 'editor@demo.com'],
            [
                'name' => 'Obi-Wan',
                'password' => Hash::make('editor123'),
                'email_verified_at' => now()
            ]
        );

        $editor_user->roles()->sync([$role_editor->id]);

        // Posts
        $admin_post = Post::firstOrCreate(
            [
                'title' => 'Hello World',
                'author_id' => $admin_user->id
            ],
            [
                'posted_at' => now(),
                'content' => "
                    Welcome to Laravel-blog !<br><br>
                    Don't forget to read the README before starting.<br><br>
                    Feel free to add a star on Laravel-blog on Github !<br><br>
                    You can open an issue or (better) a PR if something went wrong."
            ]
        );

        $editor_post = Post::firstOrCreate(
            [
                'title' => 'Editor’s First Post',
                'author_id' => $editor_user->id
            ],
            [
                'posted_at' => now(),
                'content' => "This is the first post created by the editor role user."
            ]
        );

        // Comments
        Comment::firstOrCreate(
            [
                'author_id' => $admin_user->id,
                'post_id' => $admin_post->id
            ],
            [
                'posted_at' => now(),
                'content' => "Hey! I'm a comment as an example on the admin post."
            ]
        );

        Comment::firstOrCreate(
            [
                'author_id' => $editor_user->id,
                'post_id' => $editor_post->id
            ],
            [
                'posted_at' => now(),
                'content' => "This is a comment made by the editor on their own post."
            ]
        );
    }
}
