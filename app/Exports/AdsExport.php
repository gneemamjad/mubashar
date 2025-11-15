<?php

namespace App\Exports;

use App\Models\Currency;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Current;

class AdsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ads;

    public function __construct($ads)
    {
        $this->ads = $ads;
    }

    public function collection()
    {
        return $this->ads;
    }

    public function headings(): array
    {
        return [
            'Number',
            'Title',
            'Type',
            'Category',
            'City',
            'Area',
            'Active',
            'Status',
            'Paid',
            'Price',
            'Currency',
            'Location',
            'Created At'
        ];
    }

    public function map($ad): array
    {
        $lang = app()->getLocale();
        return [
            $ad->ad_number,
            $ad->title,
            $ad->getCategoryRootAttribute()->name ?? '',
            $ad->category->name ?? '',
            $ad->city->name ?? '',
            $ad->area->name ?? '',
            $ad->active == 1 ? ($lang == 'ar' ? 'مفعل' : 'Active') : ($lang == 'ar' ? 'غير مفعل' : 'Inactive'),
            $ad->approved == 1 ? ($lang == 'ar' ? 'موافق' : 'Approved') : ($ad->approved == 0 ? ($lang == 'ar' ? 'قيد المراجعة' : 'Pending') : ($lang == 'ar' ? 'مرفوض' : 'Rejected')),
            $ad->is_paid ? ($lang == 'ar' ? 'مدفوع' : 'Paid') : ($lang == 'ar' ? 'غير مدفوع' : 'Unpaid'),
            $ad->price,
            Currency::CURRENCY[$ad->currency_id] ?? 'SYP',
            $ad->lat != null && $ad->lng != null ? 'Yes' : 'No',
            (isset($ad->created_at) ? $ad->created_at->format('Y-m-d H:i:s') : '')
        ];
    }
} 