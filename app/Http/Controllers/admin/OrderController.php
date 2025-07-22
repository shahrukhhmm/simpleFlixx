<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        session()->put('order_data', ['step' => 1, 'user_id' => Auth::id()]);
        return view('admin.pages.orders.view', compact('orders'));
    }

    public function doctorIndex()
    {
        $orders = Order::where('status', 'pending')->with('user')->get();
        return view('admin.pages.orders.view', compact('orders'));
    }

    public function pharmacyIndex()
    {
        $orders = Order::where('status', 'Approved')->with('user')->get();
        return view('admin.pages.orders.view', compact('orders'));
    }

    public function add()
    {
        return view('admin.pages.orders.index');
    }

    public function getOrders(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('user')->select(['orders.id', 'users.name', 'users.email', 'orders.created_at', 'orders.updated_at'])
                ->leftJoin('users', 'users.id', '=', 'orders.user_id');
            return DataTables::of($data)
                ->addColumn('action', function ($order) {
                    return '<button class="btn btn-sm btn-info detail-btn" data-id="' . $order->id . '">View Details</button>';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('Y-m-d H:i:s');
                })
                ->editColumn('updated_at', function ($order) {
                    return $order->updated_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function showForm($step = 1)
    {
        $step = max(1, min(9, (int)$step)); // Ensure step is between 1 and 9
        $orders = Order::with('user')->get();
        $orderData = session()->get('order_data', ['step' => $step, 'user_id' => Auth::id()]);

        // Update the session step to the requested step
        $orderData['step'] = $step;
        session()->put('order_data', $orderData);

        Log::info('Showing form for step: ' . $step, ['order_data' => $orderData]);

        return view('admin.pages.orders.index', compact('orders', 'orderData'));
    }

    /**
     * Store a new order from the JS stepper (single submit).
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $data = $request->all();

        $request->validate([
            // Step 1: Medical History
            'health_history.weight_loss_goals' => 'required|string',
            'health_history.weight_loss_initiatives' => 'required|array',
            'health_history.doctor_visit' => 'required|string',
            'health_history.weight_lbs' => 'required|numeric',
            'health_history.height_feet' => 'required|numeric',
            'health_history.height_inches' => 'required|numeric',
            'health_history.conditions' => 'required|string',
            'health_history.exercise_frequency' => 'required|string',
            'health_history.exercise_type' => 'nullable|string',
            'health_history.medications' => 'required|array',
            'health_history.gallbladder_issues' => 'required|string',
            'health_history.pancreatitis' => 'nullable|string',
            'health_history.kidney_disease' => 'nullable|string',
            'health_history.sleep_apnea' => 'nullable|string',

            // Step 2: Notice acknowledged (hidden input)
            'notice_acknowledged' => 'nullable|boolean',

            // Step 3: Weight Management Rx History
            'weight_management_history.side_effects' => 'nullable|array',
            'weight_management_history.previous_purchase' => 'required|string',
            'weight_management_history.prescription_increase' => 'required|string',
            'weight_management_history.b12_importance' => 'required|string',
            'weight_management_history.add_b12' => 'required|string',
            'weight_management_history.glycine_importance' => 'required|string',
            'weight_management_history.glp1_issues' => 'required|string',
            'weight_management_history.add_nausea_med' => 'required|string',

            // Step 4: Shipping & Billing
            'shipping_options.shipping_address1' => 'required|string',
            'shipping_options.shipping_city' => 'required|string',
            'shipping_options.shipping_state' => 'required|string',
            'shipping_options.shipping_zip' => 'required|string',
            'shipping_options.billing_same_as_shipping' => 'nullable|boolean',
            'shipping_options.billing_address1' => 'nullable|string',
            'shipping_options.billing_city' => 'nullable|string',
            'shipping_options.billing_state' => 'nullable|string',
            'shipping_options.billing_zip' => 'nullable|string',

            // Step 5: Request RX
            'medication_requests' => 'required',

            // Step 6: Add-ons
            'add_ons' => 'nullable|array',

            // Step 7: Shipping Option
            'shipping_options.shipping_option' => 'required|string|in:standard,insured',

            // Step 8: Consent
            'consent.signature' => 'required|string',

            // Step 9: Payment
            'payment_details.promo_code' => 'nullable|string|max:50',
            'payment_details.card_number' => 'required|string|digits:16',
            'payment_details.expiry_date' => 'required|string',
            'payment_details.cvv' => 'required|string|digits:3',
            'payment_details.cardholder_name' => 'required|string|max:100',
        ]);

        try {
            $order = Order::create([
                'user_id' => $userId,
                'health_history' => $data['health_history'] ?? null,
                'weight_management_history' => $data['weight_management_history'] ?? null,
                'medication_requests' => isset($data['medication_requests'])
                    ? (is_array($data['medication_requests']) ? $data['medication_requests'] : [$data['medication_requests']])
                    : [],
                'add_ons' => $data['add_ons'] ?? [],
                'shipping_options' => $data['shipping_options'] ?? null,
                'consent' => $data['consent'] ?? null,
                'payment_details' => $data['payment_details'] ?? null,
            ]);
            return redirect()->back()->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            Log::error('Order store error: ' . $e->getMessage(), ['data' => $data]);
            return redirect()->back()->with('error', 'Order creation failed');
        }
    }

    public function getOrderDetails($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return response()->json($order);
    }

    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return view('admin.pages.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'health_history' => 'nullable|array',
            'notice_acknowledged' => 'nullable|boolean',
            'weight_management_history' => 'nullable|array',
            'shipping_options' => 'nullable|array',
            'medication_requests' => 'nullable|string',
            'add_ons' => 'nullable|array',
            'consent' => 'nullable|array',
            'payment_details' => 'nullable|array',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json(['success' => 'Order updated successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected,Pending',
            'note' => 'nullable|string',
        ]);
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->doctor_id = Auth::id();
        if ($request->note) {
            $order->note = $request->note;
        }
        $order->save();
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['success' => 'Order deleted successfully.']);
    }

    public function success()
    {
        return view('admin.pages.orders.success');
    }

    public function showPharmacy($id)
    {
        $order = Order::with('user', 'doctor')->findOrFail($id);
        return view('admin.pages.pharmacy.orders', compact('order'));
    }
}
