<?php

namespace CNRP\InvoicePackage;

use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPdf\Enums\Unit;

class Invoice
{
    protected $config;
    protected $items = [];
    protected $total = 0;

    public function __construct(array $config = [], array $items = [])
    {
        $this->config = $config;
        $this->items = $items;
        $this->calculateTotal();
        Log::info('Invoice created', ['config' => $config, 'items' => $items]);
    }

    public function addItem(array $item)
    {
        $this->items[] = $item;
        $this->calculateTotal();
        Log::info('Item added', $item);
    }

    protected function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->items as $item) {
            $quantity = $item['quantity'] ?? 1;
            $price = isset($item['price']) ? (float)$item['price'] : 0.0;
            $this->total += $quantity * $price;
        }
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getColumns()
    {
        $columns = [];
        $fixedColumns = ['quantity', 'price'];

        // Collect all unique column names
        foreach ($this->items as $item) {
            foreach ($item as $key => $value) {
                if (!in_array($key, $columns)) {
                    $columns[] = $key;
                }
            }
        }

        // Remove fixed columns if they exist in the list
        $columns = array_diff($columns, $fixedColumns);

        // Append fixed columns to the end if they are present in any item
        foreach ($fixedColumns as $fixedColumn) {
            foreach ($this->items as $item) {
                if (array_key_exists($fixedColumn, $item)) {
                    $columns[] = $fixedColumn;
                    break;
                }
            }
        }
        return $columns;
    }

    protected function filterEnabledFields()
    {
        $filteredConfig = $this->config;
        foreach ($filteredConfig as $sectionKey => &$sectionData) {
            if (is_array($sectionData)) {
                foreach ($sectionData as $key => &$data) {
                    if (isset($data['enabled']) && !$data['enabled']) {
                        unset($sectionData[$key]);
                    } elseif (isset($data['fields'])) {
                        foreach ($data['fields'] as $fieldKey => $fieldData) {
                            if (isset($fieldData['enabled']) && !$fieldData['enabled']) {
                                unset($data['fields'][$fieldKey]);
                            }
                        }
                    }
                }
            }
        }
        return $filteredConfig;
    }

    public function generatePdf($customName = null)
    {
        try {
            if ($customName) {
                $filename = $this->sanitizeFileName($customName) . '.pdf';
            } else {
                $filename = 'invoice-' . time() . '.pdf';
            }
            
            $directory = storage_path('app/invoices/');
            $path = $directory . $filename;

            // Ensure the directory exists
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $filteredConfig = $this->filterEnabledFields();

            $margin = 0;
            Pdf::view('invoice::default', [
                    'items' => $this->items,
                    'total' => $this->getTotal(),
                    'config' => $filteredConfig,
                    'columns' => $this->getColumns()
                ])
                ->margins($margin, $margin, $margin, $margin, Unit::Pixel)
                ->format('a4')
                ->withBrowsershot(function ($browsershot) {
                    $browsershot->setNodeBinary(config('invoice.settings.node_binary'))->noSandbox();
                })->save($path);

            Log::info('PDF saved', ['path' => $path]);

            return $filename;
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            throw $e;
        }
    }

    public function generateAndDownloadPdf()
    {
        $filename = $this->generatePdf();
        $downloadUrl = route('invoices.download', ['filename' => $filename]);
        return redirect()->to($downloadUrl);
    }
}
