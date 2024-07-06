<?php
namespace CNRP\InvoicePackage\Components;

use Livewire\Component;
use CNRP\InvoicePackage\Invoice;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CreateInvoice extends Component
{
    public $fields = [];
    public $items = [
        ['name' => '', 'quantity' => 1, 'price' => 0],
    ];
    public $config;

    public function mount()
    {
        $this->config = Config::get('invoice');
        $this->initializeFields();
    }

    protected function initializeFields()
    {
        foreach ($this->config['invoice_structure'] as $section => $sectionData) {
            if (is_array($sectionData)) {
                foreach ($sectionData as $key => $data) {
                    if (isset($data['enabled'])) {
                        $this->fields[$section][$key] = [
                            'enabled' => $data['enabled'],
                            'value' => isset($data['fields']) ? [] : $data['default'],
                        ];
                        if (isset($data['fields'])) {
                            foreach ($data['fields'] as $fieldKey => $fieldData) {
                                $this->fields[$section][$key]['value'][$fieldKey] = [
                                    'enabled' => $fieldData['enabled'],
                                    'value' => $fieldData['default'],
                                ];
                            }
                        }
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
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
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
                    if (is_array($data['value'])) {
                        foreach ($data['value'] as $fieldKey => $fieldData) {
                            if ($fieldData['enabled']) {
                                $filteredFields[$section][$key][$fieldKey] = $fieldData['value'];
                            }
                        }
                    } else {
                        $filteredFields[$section][$key] = $data['value'];
                    }
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
                        if (isset($data['fields'])) {
                            foreach ($data['fields'] as $fieldKey => $fieldData) {
                                if ($fieldData['enabled']) {
                                    $rules["fields.{$section}.{$key}.value.{$fieldKey}.value"] = 'nullable|string';
                                }
                            }
                        } else {
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
        }
        return $rules;
    }

    public function render()
    {
        return view('invoice::livewire.create-invoice', [
            'fields' => $this->fields,
            'config' => $this->config,
        ]);
    }
}
