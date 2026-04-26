<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_group',
    ];

    protected $casts = [
        'is_group' => 'boolean',
    ];

    /**
     * Users in this chat.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('last_read_at', 'is_muted')
            ->withTimestamps();
    }

    /**
     * Messages in this chat.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * The most recent message in the chat.
     */
    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Helper to find or create a private 1-to-1 chat between two users.
     */
    public static function findOrCreatePrivateChat(int $user1Id, int $user2Id): self
    {
        // Find existing private chat between these two
        $chat = self::where('is_group', false)
            ->whereHas('users', function ($query) use ($user1Id) {
                $query->where('users.id', $user1Id);
            })
            ->whereHas('users', function ($query) use ($user2Id) {
                $query->where('users.id', $user2Id);
            })
            ->first();

        if (!$chat) {
            $chat = self::create(['is_group' => false]);
            $chat->users()->attach([$user1Id, $user2Id]);
        }

        return $chat;
    }

    /**
     * Mark the chat as read for a specific user.
     */
    public function markAsRead(int $userId): void
    {
        $this->users()->updateExistingPivot($userId, [
            'last_read_at' => now(),
        ]);
    }
}
