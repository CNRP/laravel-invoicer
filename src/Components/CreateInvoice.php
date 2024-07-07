<?php
namespace CNRP\InvoicePackage\Components;

use Livewire\Component;
use CNRP\InvoicePackage\Invoice;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class CreateInvoice extends Component
{
    public $fields = [];
    public $items = [
        ['name' => '', 'quantity' => 1, 'price' => 0],
    ];
    public $config;
    public $previewHtml;

    public function mount()
    {
        $this->config = Config::get('invoice');
        $this->initializeFields();
        $this->updatePreview();
    }

    protected function initializeFields()
    {
        foreach ($this->config['invoice_structure'] as $section => $sectionData) {
            if (is_array($sectionData)) {
                foreach ($sectionData as $key => $data) {
                    if (isset($data['enabled'])) {
                        $this->fields[$section][$key] = [
                            'enabled' => $data['enabled'],
                            'value' => $data['default'],
                        ];
                    }
                }
            }
        }

        // Set date dynamically
        if (isset($this->fields['header']['date'])) {
            $this->fields['header']['date']['value'] = Carbon::now()->toDateString();
        }
    }

    public function addItem()
    {
        $this->items[] = ['name' => '', 'quantity' => 1, 'price' => 0];
        $this->updatePreview();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->updatePreview();
    }

    public function createInvoice()
    {
        $rules = $this->generateValidationRules();
        $filteredFields = $this->filterEnabledFields($this->fields);

        $data = [
            'fields' => $filteredFields,
            'items' => $this->items,
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $invoice = new Invoice($filteredFields, $this->items);
        return $invoice->generateAndDownloadPdf();
    }

    protected function filterEnabledFields($fields)
    {
        $filteredFields = [];

        foreach ($fields as $section => $sectionData) {
            foreach ($sectionData as $key => $data) {
                if ($data['enabled']) {
                    $filteredFields[$section][$key] = $data['value'];
                }
            }
        }

        return $filteredFields;
    }

    protected function generateValidationRules()
    {
        $rules = [];
        foreach ($this->config['invoice_structure'] as $section => $sectionData) {
            if (is_array($sectionData)) {
                foreach ($sectionData as $key => $data) {
                    if (isset($data['enabled'])) {
                        $rule = 'nullable|string';
                        if ($key === 'logo') {
                            $rule = 'nullable|url';
                        } elseif ($key === 'date') {
                            $rule = 'nullable|date';
                        } elseif ($key === 'is_paid') {
                            $rule = 'boolean';
                        }
                        $rules["fields.{$section}.{$key}.value"] = $rule;
                    }
                }
            }
        }
        return $rules;
    }

    public function updated($name, $value)
    {
        $this->updatePreview();
    }

    public function updatePreview()
    {
        $filteredFields = $this->filterEnabledFields($this->fields);
        $invoice = new Invoice($filteredFields, $this->items);

        $this->previewHtml = View::make('invoice::default', [
            'items' => $this->items,
            'total' => $invoice->getTotal(),
            'config' => $filteredFields,
            'columns' => $invoice->getColumns()
        ])->render();
    }

    public function render()
    {
        return view('invoice::livewire.create-invoice', [
            'fields' => $this->fields,
            'config' => $this->config,
            'previewHtml' => $this->previewHtml,
        ]);
    }
}
