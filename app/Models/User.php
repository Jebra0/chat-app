<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'avatar', 'last_seen_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Chats the user is part of.
     */
    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class)
            ->withPivot('last_read_at', 'is_muted')
            ->withTimestamps();
    }

    /**
     * Messages sent by the user.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Friendships initiated by this user.
     */
    public function friendshipsOfMine(): HasMany
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    /**
     * Friendships received by this user.
     */
    public function friendshipsToMe(): HasMany
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    /**
     * Get all accepted friends (merged).
     */
    public function getFriendsAttribute()
    {
        $sent = $this->friendshipsOfMine()->where('status', Friendship::STATUS_ACCEPTED)->get()->pluck('friend');
        $received = $this->friendshipsToMe()->where('status', Friendship::STATUS_ACCEPTED)->get()->pluck('user');

        return $sent->merge($received);
    }

    /**
     * Helper to check if a user is friends with another user.
     */
    public function isFriendsWith(int $userId): bool
    {
        return Friendship::where('status', Friendship::STATUS_ACCEPTED)
            ->where(function ($query) use ($userId) {
                $query->where(function ($q) use ($userId) {
                    $q->where('user_id', $this->id)->where('friend_id', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('user_id', $userId)->where('friend_id', $this->id);
                });
            })->exists();
    }

    /**
     * Check if the user is currently online (seen in the last 5 minutes).
     */
    public function getIsOnlineAttribute(): bool
    {
        return $this->last_seen_at && $this->last_seen_at->isAfter(now()->subMinutes(5));
    }

    /**
     * Get the full URL for the user avatar, or a default one.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset($this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
