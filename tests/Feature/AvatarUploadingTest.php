<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AvatarUploadingTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauth_user_can_not_upload_avatar() {
        \Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post('/account/upload-avatar/', [
            'avatar' => $file,
        ]);

        \Storage::disk('avatars')->assertMissing('avatar.jpg');
    }

    public function test_user_can_upload_only_images() {
        \Storage::fake('avatars');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('virus.exe');

        $this->actingAs($user)->json('POST', '/account/upload-avatar/', [
            'avatar' => $file
        ]);
        $this->post('/account/save');

        \Storage::disk('avatars')->missing($user->avatar);

    }

    public function test_auth_user_can_upload_avatar() {
        $this->withoutExceptionHandling();
        \Storage::fake('avatars');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->actingAs($user)->json('POST', '/account/upload-avatar/', [
            'avatar' => $file
        ]);
        $this->post('/account/save');

        \Storage::disk('avatars')->assertExists($user->avatar);
        \Storage::disk('avatars')->delete($user->avatar);
    }
}
