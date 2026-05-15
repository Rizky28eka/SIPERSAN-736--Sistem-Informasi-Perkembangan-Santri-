<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

/**
 * Controller API Notifikasi
 * Endpoint AJAX untuk sistem notifikasi pengumuman real-time via Pusher.
 */
class Notifications extends BaseController
{
    /**
     * Hitung pengumuman belum dibaca oleh user yang sedang login
     */
    public function count()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['count' => 0]);
        }

        $userId = session()->get('user_id');
        $role   = session()->get('role');
        $db     = \Config\Database::connect();

        // Hitung pengumuman yang relevan dan belum dibaca
        $count = $db->table('announcements')
            ->select('id')
            ->groupStart()
                ->where('target_role', 'all')
                ->orWhere('target_role', $role)
            ->groupEnd()
            ->whereNotIn('id', function($subQuery) use ($userId) {
                $subQuery->select('announcement_id')
                         ->from('announcement_reads')
                         ->where('user_id', $userId);
            })
            ->countAllResults();

        return $this->response->setJSON(['count' => $count]);
    }

    /**
     * Ambil daftar pengumuman belum dibaca
     */
    public function list()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $role   = session()->get('role');
        $db     = \Config\Database::connect();

        $unread = $db->table('announcements')
            ->select('id, title, content, created_at')
            ->groupStart()
                ->where('target_role', 'all')
                ->orWhere('target_role', $role)
            ->groupEnd()
            ->whereNotIn('id', function($sq) use ($userId) {
                $sq->select('announcement_id')->from('announcement_reads')->where('user_id', $userId);
            })
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return $this->response->setJSON(['notifications' => $unread]);
    }

    /**
     * Tandai semua pengumuman sebagai sudah dibaca
     */
    public function markAllRead()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $role   = session()->get('role');
        $db     = \Config\Database::connect();

        // Ambil semua announcement yang belum dibaca
        $unread = $db->table('announcements')
            ->select('id')
            ->groupStart()
                ->where('target_role', 'all')
                ->orWhere('target_role', $role)
            ->groupEnd()
            ->whereNotIn('id', function($sq) use ($userId) {
                $sq->select('announcement_id')->from('announcement_reads')->where('user_id', $userId);
            })
            ->get()->getResultArray();

        foreach ($unread as $ann) {
            $db->table('announcement_reads')->insert([
                'user_id'         => $userId,
                'announcement_id' => $ann['id'],
                'read_at'         => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * Pusher auth endpoint (untuk private channels jika diperlukan)
     */
    public function pusherAuth()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $pusherKey    = getenv('PUSHER_APP_KEY');
        $pusherSecret = getenv('PUSHER_APP_SECRET');
        $appId        = getenv('PUSHER_APP_ID');

        $pusher = new \Pusher\Pusher($pusherKey, $pusherSecret, $appId, [
            'cluster' => getenv('PUSHER_APP_CLUSTER') ?: 'ap1',
        ]);

        $channelName = $this->request->getPost('channel_name');
        $socketId    = $this->request->getPost('socket_id');
        $auth        = $pusher->authorizeChannel($channelName, $socketId);

        return $this->response->setJSON($auth);
    }
}
