<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CustomersList extends Component
{
    use WithPagination;

    // Search and filters
    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';

    // Bulk actions
    public $selectedCustomers = [];
    public $selectAll = false;
    public $bulkAction = '';

    // Modal states
    public $viewingCustomer = null;
    public $showViewModal = false;
    public $confirmingCustomerDeletion = false;
    public $customerToDelete = null;

    // To prevent unwanted pagination reset
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
    ];

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
            $this->selectedCustomers = $this->customers->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedCustomers = [];
        }
    }

    public function getCustomersProperty()
    {
        return $this->customersQuery->get();
    }

    public function getCustomersQueryProperty()
    {
        $query = User::query()
            ->where('role', 'CUSTOMER');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
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
     * Show customer details in modal
     */
    public function viewCustomer($id)
    {
        $customer = User::find($id);

        if ($customer && $customer->role === 'CUSTOMER') {
            $this->viewingCustomer = $customer;
            $this->showViewModal = true;
        }
    }

    /**
     * Close the view modal
     */
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewingCustomer = null;
    }

    /**
     * Confirm customer deletion
     */
    public function confirmCustomerDeletion($id)
    {
        $this->confirmingCustomerDeletion = true;
        $this->customerToDelete = $id;
    }

    /**
     * Cancel customer deletion
     */
    public function cancelCustomerDeletion()
    {
        $this->confirmingCustomerDeletion = false;
        $this->customerToDelete = null;
    }

    /**
     * Delete the customer
     */
    public function deleteCustomer()
    {
        if (!$this->customerToDelete) {
            return;
        }

        $customer = User::find($this->customerToDelete);

        if ($customer && $customer->role === 'CUSTOMER') {
            try {
                // You might want to check if there are related records before deleting
                $customer->delete();
                session()->flash('message', 'Customer deleted successfully.');

                // Reset confirmation state
                $this->confirmingCustomerDeletion = false;
                $this->customerToDelete = null;
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to delete customer: ' . $e->getMessage());
            }
        }
    }

    /**
     * Apply bulk action to selected customers
     */
    public function applyBulkAction()
    {
        if (empty($this->selectedCustomers) || empty($this->bulkAction)) {
            return;
        }

        $customers = User::whereIn('id', $this->selectedCustomers)
                          ->where('role', 'CUSTOMER');

        switch ($this->bulkAction) {
            case 'delete':
                // Delete selected customers
                $customers->delete();
                session()->flash('message', 'Customers deleted successfully.');
                break;

            case 'activate':
                // Activate selected customers
                $customers->update(['status' => 'active']);
                session()->flash('message', 'Customers activated successfully.');
                break;

            case 'deactivate':
                // Deactivate selected customers
                $customers->update(['status' => 'inactive']);
                session()->flash('message', 'Customers deactivated successfully.');
                break;

            case 'block':
                // Block selected customers
                $customers->update(['status' => 'blocked']);
                session()->flash('message', 'Customers blocked successfully.');
                break;
        }

        // Reset selection
        $this->selectedCustomers = [];
        $this->selectAll = false;
        $this->bulkAction = '';
    }

    public function render()
    {
        $customers = User::where('role', 'CUSTOMER')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('username', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFilter, function ($query) {
                $now = Carbon::now();
                switch ($this->dateFilter) {
                    case 'today':
                        $query->whereDate('created_at', $now->toDateString());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', $now->month)
                              ->whereYear('created_at', $now->year);
                        break;
                    case 'year':
                        $query->whereYear('created_at', $now->year);
                        break;
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $total = $customers->total();

        return view('livewire.admin.customers-list', [
            'customers' => $customers,
            'total' => $total
        ]);
    }
}
