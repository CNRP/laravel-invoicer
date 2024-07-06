<?php

namespace CNRP\InvoicePackage\Components;

use Livewire\Component;
use CNRP\InvoicePackage\Invoice;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class CreateInvoice extends Component
{
    public $fields = [
        'logo' => '',
        'title' => 'INVOICE',
        'invoice_number' => '',
        'date' => '',
        'from' => [
            'name' => '',
            'phone' => '',
            'email' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'address_line_3' => '',
        ],
        'to' => [
            'name' => '',
            'phone' => '',
            'email' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'address_line_3' => '',
        ],
        'description' => '',
        'payment_terms' => '',
        'payment_details' => '',
        'footer' => '',
        'is_paid' => false,
    ];

    public $items = [
        ['name' => '', 'quantity' => 1, 'price' => 0],
    ];

    public function mount()
    {
        // $this->fields['date'] = Carbon::now()->toDateString();

        $this->fields = [
            'logo' => Config::get('invoice.logo', ''),
            'title' => Config::get('invoice.title', 'INVOICE'),
            'invoice_number' => Config::get('invoice.invoice_number', 'INV-0001'),
            'date' => now()->toDateString(),
            'from' => [
                'name' => Config::get('invoice.from.name', ''),
                'phone' => Config::get('invoice.from.phone', ''),
                'email' => Config::get('invoice.from.email', ''),
                'address_line_1' => Config::get('invoice.from.address_line_1', ''),
                'address_line_2' => Config::get('invoice.from.address_line_2', ''),
                'address_line_3' => Config::get('invoice.from.address_line_3', ''),
            ],
            'to' => [
                'name' => '',
                'phone' => '',
                'email' => '',
                'address_line_1' => '',
                'address_line_2' => '',
                'address_line_3' => '',
            ],
            'description' => Config::get('invoice.description', ''),
            'payment_terms' => Config::get('invoice.payment_terms', ''),
            'payment_details' => Config::get('invoice.payment_details', ''),
            'footer' => Config::get('invoice.footer', ''),
            'is_paid' => Config::get('invoice.is_paid', false),
        ];
    }

    public function addItem()
    {
        $this->items[] = ['name' => '', 'quantity' => 1, 'price' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function createInvoice()
    {
        $rules = [
            'fields.logo' => 'nullable|url',
            'fields.title' => 'required|string',
            'fields.invoice_number' => 'required|string',
            'fields.date' => 'required|date',
            'fields.from.name' => 'required|string',
            'fields.from.phone' => 'nullable|string',
            'fields.from.email' => 'nullable|email',
            'fields.from.address_line_1' => 'required|string',
            'fields.from.address_line_2' => 'nullable|string',
            'fields.from.address_line_3' => 'nullable|string',
            'fields.to.name' => 'required|string',
            'fields.to.phone' => 'nullable|string',
            'fields.to.email' => 'nullable|email',
            'fields.to.address_line_1' => 'required|string',
            'fields.to.address_line_2' => 'nullable|string',
            'fields.to.address_line_3' => 'nullable|string',
            'fields.description' => 'required|string',
            'fields.payment_terms' => 'required|string',
            'fields.payment_details' => 'required|string',
            'fields.footer' => 'nullable|string',
            'fields.is_paid' => 'boolean',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ];

        $data = $this->validate($rules);

        $invoice = new Invoice($this->fields, $this->items);

        return $invoice->generateAndDownloadPdf();
    }

    public function render()
    {
        return view('invoice::livewire.create-invoice');
    }
}
