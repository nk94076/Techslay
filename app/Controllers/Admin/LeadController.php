<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Models\ActivityLog;
use App\Models\ContactLead;

final class LeadController extends Controller
{
    private const STATUSES = ['new', 'contacted', 'qualified', 'closed', 'spam'];

    public function index(): void
    {
        $status = (string) $this->input('status', '');
        $type = (string) $this->input('type', '');

        $sql = 'SELECT * FROM contact_leads WHERE 1=1';
        $params = [];

        if (in_array($status, self::STATUSES, true)) {
            $sql .= ' AND status = :status';
            $params['status'] = $status;
        }

        if (in_array($type, ['advertiser', 'publisher', 'general', 'career'], true)) {
            $sql .= ' AND lead_type = :type';
            $params['type'] = $type;
        }

        $sql .= ' ORDER BY created_at DESC';

        $this->view('admin.leads.index', [
            'pageTitle' => 'Leads',
            'pageHeading' => 'Leads',
            'leads' => Database::fetchAll($sql, $params),
            'statuses' => self::STATUSES,
            'activeStatus' => $status,
            'activeType' => $type,
        ], 'admin.layouts.app');
    }

    public function updateStatus(int $id): void
    {
        $this->requireCsrf();

        $status = (string) $this->input('status', '');

        if (!in_array($status, self::STATUSES, true)) {
            $this->abort(422, 'Invalid status.');

            return;
        }

        ContactLead::update($id, ['status' => $status]);
        ActivityLog::record('lead.status_update', 'contact_lead', $id, $status);

        Session::flash('success', 'Lead status updated.');
        $this->back();
    }

    public function export(): void
    {
        $leads = Database::fetchAll('SELECT * FROM contact_leads ORDER BY created_at DESC');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="leads-' . date('Y-m-d') . '.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Name', 'Email', 'Phone', 'Company', 'Type', 'Message', 'Status', 'Received At'], ',', '"', '\\');

        foreach ($leads as $lead) {
            fputcsv($out, [
                $lead['id'], $lead['name'], $lead['email'], $lead['phone'], $lead['company'],
                $lead['lead_type'], $lead['message'], $lead['status'], $lead['created_at'],
            ], ',', '"', '\\');
        }

        fclose($out);
    }

    public function delete(int $id): void
    {
        $this->requireCsrf();

        Database::query('DELETE FROM contact_leads WHERE id = :id', ['id' => $id]);
        ActivityLog::record('lead.delete', 'contact_lead', $id);

        Session::flash('success', 'Lead deleted.');
        $this->back();
    }
}
