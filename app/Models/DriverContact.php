<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'driver_contacts';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'topic',
        'subject',
        'message',
        'status',
        'admin_notes',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Scope để lọc theo trạng thái
     */
    public function scopeByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope để tìm kiếm
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    /**
     * Lấy text hiển thị cho trạng thái
     */
    public function getStatusTextAttribute()
    {
        $statusLabels = [
            'unread' => 'Chưa đọc',
            'read' => 'Đã đọc',
            'replied' => 'Đã trả lời',
            'closed' => 'Đã đóng'
        ];

        return $statusLabels[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Lấy class CSS cho trạng thái
     */
    public function getStatusClassAttribute()
    {
        $statusClasses = [
            'unread' => 'badge-danger',
            'read' => 'badge-warning',
            'replied' => 'badge-success',
            'closed' => 'badge-secondary'
        ];

        return $statusClasses[$this->status] ?? 'badge-light';
    }

    /**
     * Lấy text hiển thị cho chủ đề
     */
    public function getTopicTextAttribute()
    {
        $topicLabels = [
            'khiếu nại' => 'Khiếu nại',
            'tư vấn dịch vụ' => 'Tư vấn dịch vụ',
            'phản hồi' => 'Phản hồi',
            'khác' => 'Khác'
        ];

        return $topicLabels[$this->topic] ?? ucfirst($this->topic);
    }

    /**
     * Lấy class CSS cho chủ đề
     */
    public function getTopicClassAttribute()
    {
        $topicClasses = [
            'khiếu nại' => 'badge-danger',
            'tư vấn dịch vụ' => 'badge-info',
            'phản hồi' => 'badge-success',
            'khác' => 'badge-secondary'
        ];

        return $topicClasses[$this->topic] ?? 'badge-light';
    }
}


