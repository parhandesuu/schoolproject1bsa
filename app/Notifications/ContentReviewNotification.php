<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ContentReviewNotification extends Notification
{
    use Queueable;

    public string $type; // 'post' or 'page'
    public int $contentId;
    public string $title;
    public string $submittedByName;
    public string $actionUrl;

    public function __construct(string $type, int $contentId, string $title, string $submittedByName, string $actionUrl)
    {
        $this->type = $type;
        $this->contentId = $contentId;
        $this->title = $title;
        $this->submittedByName = $submittedByName;
        $this->actionUrl = $actionUrl;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'content_id' => $this->contentId,
            'title' => $this->title,
            'submitted_by' => $this->submittedByName,
            'action_url' => $this->actionUrl,
            'message' => "Pengajuan {$this->type} baru '{$this->title}' diajukan oleh {$this->submittedByName} dan menunggu persetujuan.",
        ];
    }
}
