<?php

namespace App\Http\Livewire\Agent\Setting;

use App\Settings\TicketSettings;
use Livewire\Component;

class TicketSettingManager extends Component
{
    public $allowAssignmentToAdmins;
    public $allowAgentToAssignTicket;
    public $allowAgentToResignTicket;
    public $allowAgentToSeeLicenseCode;

    protected $rules = [
        'allowAssignmentToAdmins' => 'boolean',
        'allowAgentToAssignTicket' => 'boolean',
        'allowAgentToResignTicket' => 'boolean',
        'allowAgentToSeeLicenseCode' => 'boolean',
    ];

    public function mount()
    {
        abort_if(! auth()->user()->is_admin, 403);
        $this->allowAssignmentToAdmins = $this->ticketSettings->allow_assignment_to_admins;
        $this->allowAgentToAssignTicket = $this->ticketSettings->allow_agent_to_assign_ticket;
        $this->allowAgentToResignTicket = $this->ticketSettings->allow_agent_to_resign_ticket;
        $this->allowAgentToSeeLicenseCode = $this->ticketSettings->allow_agent_to_see_license_code;
    }

    public function save()
    {
        $this->validate();
        $this->ticketSettings->allow_assignment_to_admins = $this->allowAssignmentToAdmins;
        $this->ticketSettings->allow_agent_to_assign_ticket = $this->allowAgentToAssignTicket;
        $this->ticketSettings->allow_agent_to_resign_ticket = $this->allowAgentToResignTicket;
        $this->ticketSettings->allow_agent_to_see_license_code = $this->allowAgentToSeeLicenseCode;
        $this->ticketSettings->save();
        $this->emitSelf('saved');
    }

    public function getTicketSettingsProperty()
    {
        return app(TicketSettings::class);
    }

    public function render()
    {
        return view('livewire.agent.setting.ticket-setting-manager');
    }
}
