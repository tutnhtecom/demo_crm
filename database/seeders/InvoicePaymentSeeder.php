<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvoicePaymentSeeder extends Seeder
{
    public function run(): void
    {
        $invoiceCount  = 0;
        $paymentCount  = 0;

        $subscriptions = Subscription::with(['customer', 'package'])->get();

        foreach ($subscriptions as $subscription) {
            $customer = $subscription->customer;
            $package  = $subscription->package;

            // Tạo hóa đơn cho tháng hiện tại
            $issueDate = Carbon::parse($subscription->start_date);
            $dueDate   = $issueDate->copy()->addDays(15);
            $price     = $subscription->price_at_subscription;
            $tax       = round($price * 0.1, 0);

            $invoice = Invoice::updateOrCreate(
                [
                    'customer_id'     => $customer->id,
                    'subscription_id' => $subscription->id,
                    'type'            => 'subscription',
                ],
                [
                    'invoice_number'  => 'INV-' . date('Ym') . '-' . str_pad($customer->id, 5, '0', STR_PAD_LEFT),
                    'customer_id'     => $customer->id,
                    'subscription_id' => $subscription->id,
                    'type'            => 'subscription',
                    'subtotal'        => $price,
                    'tax_rate'        => 10.00,
                    'tax_amount'      => $tax,
                    'discount_amount' => 0,
                    'total_amount'    => $price + $tax,
                    'issue_date'      => $issueDate->toDateString(),
                    'due_date'        => $dueDate->toDateString(),
                    'period_from'     => $subscription->start_date,
                    'period_to'       => $subscription->end_date,
                    'status'          => $subscription->status === 'active' ? 'paid' : 'overdue',
                    'paid_amount'     => $subscription->status === 'active' ? ($price + $tax) : 0,
                    'paid_date'       => $subscription->status === 'active' ? $issueDate->copy()->addDays(3)->toDateString() : null,
                    'notes'           => 'Hóa đơn cước dịch vụ Voice IP - Gói ' . $package->name,
                ]
            );

            $invoiceCount++;

            // Tạo payment cho hóa đơn đã thanh toán
            if ($invoice->status === 'paid') {
                $methods = ['bank_transfer', 'e_wallet', 'vnpay', 'momo'];

                Payment::updateOrCreate(
                    ['invoice_id' => $invoice->id],
                    [
                        'transaction_code'      => 'TXN-' . strtoupper(uniqid()),
                        'customer_id'           => $customer->id,
                        'invoice_id'            => $invoice->id,
                        'amount'                => $invoice->total_amount,
                        'payment_method'        => $methods[array_rand($methods)],
                        'status'                => 'completed',
                        'gateway_transaction_id'=> 'GW' . rand(100000000, 999999999),
                        'description'           => 'Thanh toán ' . $invoice->invoice_number,
                        'paid_at'               => Carbon::parse($invoice->paid_date)->setHour(rand(8, 17)),
                        'confirmed_by'          => 1,
                        'confirmed_at'          => Carbon::parse($invoice->paid_date)->setHour(rand(8, 17))->addMinutes(30),
                    ]
                );

                $paymentCount++;
            }
        }

        // Tạo thêm một số hóa đơn cước sử dụng
        $this->createUsageInvoices();

        $this->command->info("✅ Invoices seeded: {$invoiceCount} records");
        $this->command->info("✅ Payments seeded: {$paymentCount} records");
    }

    private function createUsageInvoices(): void
    {
        $customer = Customer::where('email', 'info@techsolutionvn.com')->first();
        if (!$customer) return;

        Invoice::create([
            'invoice_number'  => 'INV-USAGE-' . date('Ym') . '-001',
            'customer_id'     => $customer->id,
            'subscription_id' => null,
            'type'            => 'usage',
            'subtotal'        => 350000,
            'tax_rate'        => 10.00,
            'tax_amount'      => 35000,
            'discount_amount' => 0,
            'total_amount'    => 385000,
            'issue_date'      => Carbon::now()->subDays(5)->toDateString(),
            'due_date'        => Carbon::now()->addDays(10)->toDateString(),
            'period_from'     => Carbon::now()->startOfMonth()->toDateString(),
            'period_to'       => Carbon::now()->toDateString(),
            'status'          => 'issued',
            'paid_amount'     => 0,
            'notes'           => 'Cước sử dụng vượt mức - Gọi quốc tế tháng ' . now()->format('m/Y'),
        ]);
    }
}
