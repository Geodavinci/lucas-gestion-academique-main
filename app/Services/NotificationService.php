<?php

namespace App\Services;

use App\Mail\MemoireSubmittedNotification as MemoireSubmittedMail;
use App\Mail\JuryAssignedNotification as JuryAssignedMail;
use App\Mail\SoutenanceScheduledNotification as SoutenanceScheduledMail;
use App\Mail\CorrectionCompleteNotification as CorrectionCompleteMail;
use App\Models\Notification;
use App\Models\Memoire;
use App\Models\Soutenance;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function notifyAdminsOfMemoireSubmitted(Memoire $memoire): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'memoire_submitted',
                'title' => 'Nouveau mémoire soumis',
                'message' => "{$memoire->student->nom} {$memoire->student->prenom} a soumis un mémoire: \"{$memoire->titre}\"",
                'data' => [
                    'memoire_id' => $memoire->id,
                    'student_id' => $memoire->student_id,
                ],
            ]);
        }
    }

    public static function notifyTeachersJuryAssigned(Soutenance $soutenance): void
    {
        $teachers = collect([
            $soutenance->directeurMemoire,
            $soutenance->evaluateurTeacher,
            $soutenance->presidentJury,
        ])->filter();

        foreach ($teachers as $teacher) {
            if (!$teacher || !$teacher->user) {
                continue;
            }

            Notification::create([
                'user_id' => $teacher->user->id,
                'type' => 'jury_assigned',
                'title' => 'Assignation à un jury',
                'message' => "Vous êtes assigné au jury de {$soutenance->student->nom} {$soutenance->student->prenom}",
                'data' => [
                    'soutenance_id' => $soutenance->id,
                    'student_id' => $soutenance->student_id,
                ],
            ]);

            if ($teacher->user->email) {
                Mail::queue(new JuryAssignedMail($soutenance, $teacher));
            }
        }
    }

    public static function notifyStudentSoutenanceScheduled(Soutenance $soutenance): void
    {
        $student = $soutenance->student;

        if (!$student || !$student->user) {
            return;
        }

        $dateStr = $soutenance->date_soutenance
            ? $soutenance->date_soutenance->format('d/m/Y H:i')
            : 'À déterminer';

        Notification::create([
            'user_id' => $student->user->id,
            'type' => 'soutenance_scheduled',
            'title' => 'Votre soutenance est programmée',
            'message' => "Votre soutenance est programmée pour le $dateStr",
            'data' => [
                'soutenance_id' => $soutenance->id,
            ],
        ]);

        if ($student->user->email) {
            Mail::queue(new SoutenanceScheduledMail($soutenance));
        }
    }

    public static function notifyStudentMemoireUpdated(Memoire $memoire, string $status = null): void
    {
        $student = $memoire->student;

        if (!$student || !$student->user) {
            return;
        }

        $statusText = $status ? " - Statut: $status" : '';

        Notification::create([
            'user_id' => $student->user->id,
            'type' => 'memoire_updated',
            'title' => 'Votre mémoire a été mis à jour',
            'message' => "Votre mémoire \"{$memoire->titre}\" a été mis à jour{$statusText}",
            'data' => [
                'memoire_id' => $memoire->id,
            ],
        ]);

        if ($student->user->email) {
            Mail::queue(new CorrectionCompleteMail($memoire));
        }
    }

    public static function notifyCustom(User $user, string $type, string $title, string $message, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
