<?php

namespace App\Exports;

use App\Models\Bank;
use App\Models\Currency;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Transaction ID',
            'Payment Method',
            'Amount',
            'Currency',
            'Status',
            'User Name',
            'User Email',
            'User Phone',
            'Ad Number',
            'Ad Title',
            'Ad Category',
            'Transaction Date'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_id,
            Bank::BANKS_NAME[$transaction->bank_id] ?? '',
            $transaction->amount,
            Currency::CURRENCY[$transaction->currency_id],
            $transaction->status,
            $transaction->user->first_name . ' ' . $transaction->user->last_name,
            $transaction->user->email,
            $transaction->user->mobile,
            $transaction->ad_number,
            $transaction->ad->title ?? 'N/A',
            $transaction->ad->category->name ?? 'N/A',
            $transaction->created_at->format('Y-m-d H:i:s')
        ];
    }
} 