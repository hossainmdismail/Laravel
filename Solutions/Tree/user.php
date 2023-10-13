<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'left_child_id',
        'right_child_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function totalDownlineCount($side = null)
    {
        if ($side === 'left') {
            return $this->countDownline($this->left_child_id);
        } elseif ($side === 'right') {
            return $this->countDownline($this->right_child_id);
        } else {
            $leftCount = $this->countDownline($this->left_child_id);
            $rightCount = $this->countDownline($this->right_child_id);
            return [
                'left' => $leftCount,
                'right' => $rightCount,
            ];
        }
    }

    private function countDownline($childId)
    {
        if ($childId === null) {
            return 0;
        }
        $child = User::find($childId);
        if ($child === null) {
            return 0;
        }
        $leftCount = $child->countDownline($child->left_child_id);
        $rightCount = $child->countDownline($child->right_child_id);
        return $leftCount + $rightCount + 1;
    }

    public function lastUserInDownline($side = null)
    {
        if ($side === 'left') {
            return $this->findLastUser($this->left_child_id);
        } elseif ($side === 'right') {
            return $this->findLastUser($this->right_child_id);
        } else {
            $leftLast = $this->findLastUser($this->left_child_id);
            $rightLast = $this->findLastUser($this->right_child_id);
            return [
                'left' => $leftLast,
                'right' => $rightLast,
            ];
        }
    }

    private function findLastUser($childId)
    {
        if ($childId === null) {
            return $this;
        }
        $child = User::find($childId);
        if ($child === null) {
            return $this;
        }
        if ($child->left_child_id == null || $child->right_child_id == null) {
            return $child;
        }
        return $child->findLastUser($child->right_child_id);
    }
}
