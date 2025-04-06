<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::where('role', 'CUSTOMER');

            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }

            // Apply status filter
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            // Apply date filter
            if ($request->has('date_filter') && !empty($request->date_filter)) {
                $dateFilter = $request->date_filter;

                switch ($dateFilter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year);
                        break;
                    case 'year':
                        $query->whereYear('created_at', now()->year);
                        break;
                }
            }

            // Order by creation date
            $query->orderBy('created_at', 'desc');

            // Paginate results
            $customers = $query->paginate(15);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'customers' => $customers
                ]);
            }

            return view('admin.simple-customers', compact('customers'));
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error fetching customers: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error fetching customers: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $customer = User::findOrFail($id);

            // Check if the customer is actually a customer
            if ($customer->role !== 'CUSTOMER') {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User is not a customer'
                    ], 403);
                }

                return redirect()->route('admin.customers')->with('error', 'User is not a customer');
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'customer' => $customer
                ]);
            }

            return view('admin.customers.show', compact('customer'));
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found: ' . $e->getMessage()
                ], 404);
            }

            return redirect()->route('admin.customers')->with('error', 'Customer not found');
        }
    }

    public function destroy($id)
    {
        try {
            $customer = User::findOrFail($id);

            // Delete associated data if needed
            // For example: $customer->orders()->delete();

            $customer->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer deleted successfully'
                ]);
            }

            return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting customer: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.customers')->with('error', 'Error deleting customer: ' . $e->getMessage());
        }
    }
}
