<?php
namespace CNRP\InvoicePackage\Components;

use Livewire\Component;

class InvoiceItems extends Component
{
    public $items = [];
    public $columns = ['name' => 'Name', 'quantity' => 'Quantity', 'price' => 'Price'];
    public $newColumnName;

    public function mount($items)
    {
        $this->items = $items;
    }

    public function addItem()
    {
        $newItem = [];
        foreach ($this->columns as $key => $label) {
            $newItem[$key] = '';
        }
        $this->items[] = $newItem;
        $this->dispatch('itemsUpdated', $this->items);
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->dispatch('itemsUpdated', $this->items);
    }

    public function addColumn()
    {
        if ($this->newColumnName && !in_array($this->newColumnName, array_keys($this->columns))) {
            $columnKey = strtolower(str_replace(' ', '_', $this->newColumnName));
            $this->columns[$columnKey] = $this->newColumnName;
            foreach ($this->items as &$item) {
                $item[$columnKey] = '';
            }
            $this->dispatch('columnsUpdated', $this->columns);
            $this->newColumnName = '';
        }
    }

    public function removeColumn($columnName)
    {
        if ($columnName === 'price') {
            return;
        }

        unset($this->columns[$columnName]);
        foreach ($this->items as &$item) {
            unset($item[$columnName]);
        }
        $this->dispatch('columnsUpdated', $this->columns);
    }

    public function updated($name, $value)
    {
        $this->dispatch('itemsUpdated', $this->items);
    }

    public function render()
    {
        return view('invoice::livewire.invoice-items', [
            'items' => $this->items,
            'columns' => $this->columns,
        ]);
    }
}
