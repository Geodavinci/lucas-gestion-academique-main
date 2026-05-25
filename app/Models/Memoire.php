<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Memoire extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'titre',
        'annee',
        'fichier_pdf',
        'fichier_pdf_corrige',
        'status',
        'submitted_at',
        'reviewed_at',
        'reviewer_id',
        'review_notes',
        'version',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function history()
    {
        return $this->hasMany(MemoireHistory::class)->orderByDesc('created_at');
    }

    public function submit()
    {
        $oldStatus = $this->status;
        $this->update([
            'status' => 'submitted',
            'submitted_at' => now(),
            'version' => $this->version + 1,
        ]);

        MemoireHistory::create([
            'memoire_id' => $this->id,
            'user_id' => Auth::id(),
            'action' => 'submitted',
            'old_status' => $oldStatus,
            'new_status' => 'submitted',
        ]);
    }

    public function markUnderReview()
    {
        $oldStatus = $this->status;
        $this->update([
            'status' => 'in_review',
            'reviewer_id' => Auth::id(),
        ]);

        MemoireHistory::create([
            'memoire_id' => $this->id,
            'user_id' => Auth::id(),
            'action' => 'reviewed',
            'old_status' => $oldStatus,
            'new_status' => 'in_review',
        ]);
    }

    public function requestChanges(string $notes)
    {
        $oldStatus = $this->status;
        $this->update([
            'status' => 'changes_requested',
            'review_notes' => $notes,
            'reviewed_at' => now(),
        ]);

        MemoireHistory::create([
            'memoire_id' => $this->id,
            'user_id' => Auth::id(),
            'action' => 'changes_requested',
            'old_status' => $oldStatus,
            'new_status' => 'changes_requested',
            'notes' => $notes,
        ]);
    }

    public function approve()
    {
        $oldStatus = $this->status;
        $this->update([
            'status' => 'approved',
            'reviewed_at' => now(),
        ]);

        MemoireHistory::create([
            'memoire_id' => $this->id,
            'user_id' => Auth::id(),
            'action' => 'approved',
            'old_status' => $oldStatus,
            'new_status' => 'approved',
        ]);
    }

    public function reject(string $reason)
    {
        $oldStatus = $this->status;
        $this->update([
            'status' => 'rejected',
            'review_notes' => $reason,
            'reviewed_at' => now(),
        ]);

        MemoireHistory::create([
            'memoire_id' => $this->id,
            'user_id' => Auth::id(),
            'action' => 'rejected',
            'old_status' => $oldStatus,
            'new_status' => 'rejected',
            'notes' => $reason,
        ]);
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, ['draft', 'changes_requested']);
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'draft' => 'Brouillon',
            'submitted' => 'Soumis',
            'in_review' => 'En révision',
            'changes_requested' => 'Corrections demandées',
            'approved' => 'Approuvé',
            'rejected' => 'Rejeté',
            default => 'Inconnu',
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'submitted' => 'blue',
            'in_review' => 'orange',
            'changes_requested' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
