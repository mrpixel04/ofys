<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\ShopInfo;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ProvidersList extends Component
{
    use WithPagination;

    // Search and filters
    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';

    // Bulk actions
    public $selectedProviders = [];
    public $selectAll = false;
    public $bulkAction = '';

    // Modal states
    public $viewingProvider = null;
    public $showViewModal = false;
    public $confirmingProviderDeletion = false;
    public $providerToDelete = null;

    // To prevent unwanted pagination reset
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
    ];

    // Listen for provider events
    protected $listeners = [
        'provider-created' => 'handleProviderCreated',
        'provider-updated' => 'handleProviderUpdated',
        'edit-provider' => 'handleEditProvider'
    ];

    // Handle the provider created event
    public function handleProviderCreated($data)
    {
        session()->flash('message', $data['message']);
        $this->resetPage();
    }

    // Handle the provider updated event
    public function handleProviderUpdated($data)
    {
        session()->flash('message', $data['message']);
    }

    // Handle the edit provider event
    public function handleEditProvider($providerId)
    {
        $this->dispatch('triggerEditProvider', $providerId);
    }

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProviders = $this->providers->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedProviders = [];
        }
    }

    public function getProvidersProperty()
    {
        return $this->providersQuery->get();
    }

    public function getProvidersQueryProperty()
    {
        $query = User::query()
            ->where('role', 'PROVIDER');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            // In this example, we're assuming there's a 'status' field
            // If it's part of a different table/relationship, adjust accordingly
            $query->where('status', $this->statusFilter);
        }

        if ($this->dateFilter) {
            // Apply date filtering based on created_at
            $now = Carbon::now();
            $query->where(function($q) use ($now) {
                switch ($this->dateFilter) {
                    case 'today':
                        $q->whereDate('created_at', $now->toDateString());
                        break;
                    case 'week':
                        $q->whereBetween('created_at', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
                        break;
                    case 'month':
                        $q->whereMonth('created_at', $now->month)
                          ->whereYear('created_at', $now->year);
                        break;
                    case 'year':
                        $q->whereYear('created_at', $now->year);
                        break;
                }
            });
        }

        return $query;
    }

    /**
     * Show provider details in modal
     */
    public function viewProvider($id)
    {
        $provider = User::with('shopInfo')->find($id);

        if ($provider && $provider->role === 'PROVIDER') {
            $this->viewingProvider = $provider;
            $this->showViewModal = true;
        }
    }

    /**
     * Close the view modal
     */
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewingProvider = null;
    }

    /**
     * Trigger edit provider slide-over panel
     */
    public function editProvider($id)
    {
        $this->dispatch('edit-provider', $id);
    }

    /**
     * Confirm provider deletion
     */
    public function confirmProviderDeletion($id)
    {
        $this->confirmingProviderDeletion = true;
        $this->providerToDelete = $id;
    }

    /**
     * Cancel provider deletion
     */
    public function cancelProviderDeletion()
    {
        $this->confirmingProviderDeletion = false;
        $this->providerToDelete = null;
    }

    /**
     * Delete the provider
     */
    public function deleteProvider()
    {
        if (!$this->providerToDelete) {
            return;
        }

        $provider = User::find($this->providerToDelete);

        if ($provider && $provider->role === 'PROVIDER') {
            try {
                $provider->delete();
                session()->flash('message', 'Provider deleted successfully.');

                // Reset confirmation state
                $this->confirmingProviderDeletion = false;
                $this->providerToDelete = null;
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to delete provider: ' . $e->getMessage());
            }
        }
    }

    public function applyBulkAction()
    {
        if (empty($this->selectedProviders) || empty($this->bulkAction)) {
            return;
        }

        $providers = User::whereIn('id', $this->selectedProviders);

        switch ($this->bulkAction) {
            case 'delete':
                // Delete selected providers
                $providers->delete();
                session()->flash('message', 'Providers deleted successfully.');
                break;

            case 'activate':
                // Activate selected providers (assuming there's a status field)
                $providers->update(['status' => 'active']);
                session()->flash('message', 'Providers activated successfully.');
                break;

            case 'deactivate':
                // Deactivate selected providers (assuming there's a status field)
                $providers->update(['status' => 'inactive']);
                session()->flash('message', 'Providers deactivated successfully.');
                break;
        }

        // Reset selection
        $this->selectedProviders = [];
        $this->selectAll = false;
        $this->bulkAction = '';
    }

    public function render()
    {
        // Paginate the results
        $providers = $this->providersQuery->paginate(10);

        // Check if all items on this page are selected
        $this->selectAll = count($this->selectedProviders) && count($this->selectedProviders) == $providers->count();

        return view('livewire.admin.providers-list', [
            'providers' => $providers
        ]);
    }
}
