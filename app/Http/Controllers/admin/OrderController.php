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
        $orders = Order::with('user')->get();
        session()->put('order_data', ['step' => 1, 'user_id' => Auth::id()]);
        return view('admin.pages.orders.index', compact('orders'));
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

    public function saveStep(Request $request, $step)
    {
        $data = $request->except('_token');
        $orderData = session()->get('order_data', ['user_id' => Auth::id(), 'step' => (int)$step]);

        Log::info('Saving step: ' . $step, ['data' => $data]);

        try {
            switch ((int)$step) {
                case 1:
                    $request->validate([
                        'weight_loss_goals' => 'required|string',
                        'weight_loss_initiatives' => 'required|array',
                        'doctor_visit' => 'required|string',
                        'weight_lbs' => 'required|numeric',
                        'height_feet' => 'required|numeric',
                        'height_inches' => 'required|numeric',
                        'conditions' => 'required|string',
                        'exercise_frequency' => 'required|string',
                        'exercise_type' => 'nullable|string',
                        'medications' => 'required|array',
                        'gallbladder_issues' => 'required|string',
                        'pancreatitis' => 'required|string',
                        'kidney_disease' => 'required|string',
                        'sleep_apnea' => 'required|string',
                    ]);
                    $orderData['health_history'] = $data;
                    break;
                case 2:
                    $orderData['notice_acknowledged'] = true;
                    break;
                case 3:
                    $request->validate([
                        'side_effects' => 'nullable|array',
                        'previous_purchase' => 'required|string',
                        'prescription_increase' => 'required|string',
                        'b12_importance' => 'required|string',
                        'add_b12' => 'required_if:b12_importance,yes|string',
                        'glycine_importance' => 'required|string',
                        'glp1_issues' => 'required|string',
                        'add_nausea_med' => 'required_if:glp1_issues,yes|string',
                    ]);
                    $orderData['weight_management_history'] = $data;
                    break;
                case 4:
                    $request->validate([
                        'shipping_address1' => 'required|string',
                        'shipping_city' => 'required|string',
                        'shipping_state' => 'required|string',
                        'shipping_zip' => 'required|string',
                        'billing_same_as_shipping' => 'nullable|boolean',
                        'billing_address1' => 'required_if:billing_same_as_shipping,0|string',
                        'billing_city' => 'required_if:billing_same_as_shipping,0|string',
                        'billing_state' => 'required_if:billing_same_as_shipping,0|string',
                        'billing_zip' => 'required_if:billing_same_as_shipping,0|string',
                    ]);
                    $orderData['shipping_options'] = $data;
                    break;
                case 5:
                    $request->validate([
                        'requested_rx' => 'required|string',
                    ]);
                    $orderData['medication_requests'] = $data['requested_rx'];
                    break;
                case 6:
                    $request->validate([
                        'add_ons' => 'nullable|array',
                    ]);
                    $orderData['add_ons'] = $data['add_ons'] ?? [];
                    break;
                case 7:
                    $request->validate([
                        'shipping_option' => 'required|string|in:standard,insured',
                    ]);
                    $orderData['shipping_options'] = array_merge($orderData['shipping_options'] ?? [], ['shipping_option' => $data['shipping_option']]);
                    break;
                case 8:
                    $request->validate([
                        'signature' => 'required|string',
                    ]);
                    $orderData['consent'] = $data;
                    break;
                case 9:
                    $request->validate([
                        'promo_code' => 'nullable|string|max:50',
                        'card_number' => 'required|string|digits:16',
                        'expiry_date' => 'required|string',
                        'cvv' => 'required|string|digits:3',
                        'cardholder_name' => 'required|string|max:100',
                    ]);
                    $orderData['payment_details'] = $data;

                    dd($orderData);

                    $order = Order::create([
                        'user_id' => $orderData['user_id'],
                        'health_history' => $orderData['health_history'] ?? null,
                        'weight_management_history' => $orderData['weight_management_history'] ?? null,
                        'medication_requests' => $orderData['medication_requests'] ?? null,
                        'add_ons' => $orderData['add_ons'] ?? [],
                        'shipping_options' => $orderData['shipping_options'] ?? null,
                        'consent' => $orderData['consent'] ?? null,
                        'payment_details' => $orderData['payment_details'] ?? null,
                    ]);

                    Log::info('Order created successfully', ['order_id' => $order->id, 'data' => $orderData]);

                    session()->forget('order_data');
                    return redirect()->route('order.success')->with('success', 'Order submitted successfully!');
                default:
                    return redirect()->route('order.form', 1)->withErrors(['message' => 'Invalid step.']);
            }

            $orderData['step'] = (int)$step + 1;
            session()->put('order_data', $orderData);
            Log::info('Redirecting to step: ' . $orderData['step'], ['order_data' => $orderData]);
            return redirect()->route('order.form', $orderData['step'])->with('status', 'Step saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving step ' . $step . ': ' . $e->getMessage(), ['data' => $data, 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['message' => 'Error saving step: ' . $e->getMessage()]);
        }
    }

    public function getOrderDetails($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return response()->json($order);
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
}
