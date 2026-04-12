<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AdminProductManager extends Component
{
    use WithFileUploads, WithPagination;

    // Modal state
    public bool   $showModal  = false;
    public ?int   $editingId  = null;

    // Form fields
    public string  $title       = '';
    public string  $category    = 'wattpad';
    public string  $description = '';
    public string  $price       = '';
    public string  $rating      = '0';
    public bool    $is_active   = true;
    public         $image;

    // Search
    public string $search = '';

    protected function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'category'    => 'required|in:wattpad,manga',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'is_active'   => 'boolean',
            'image'       => $this->editingId
                ? 'nullable|image|max:2048'
                : 'nullable|image|max:2048',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $product = Product::findOrFail($id);

        $this->editingId   = $id;
        $this->title       = $product->title;
        $this->category    = $product->category;
        $this->description = $product->description ?? '';
        $this->price       = (string) $product->price;
        $this->rating      = (string) $product->rating;
        $this->is_active   = $product->is_active;
        $this->image       = null;

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $imagePath = null;

        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
        }

        if ($this->editingId) {
            $product = Product::findOrFail($this->editingId);

            // Delete old image if replacing
            if ($imagePath && $product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->update([
                'title'       => $this->title,
                'category'    => $this->category,
                'description' => $this->description,
                'price'       => $this->price,
                'rating'      => $this->rating ?: 0,
                'is_active'   => $this->is_active,
                ...($imagePath ? ['image_path' => $imagePath] : []),
            ]);

            $this->dispatch('notify', message: 'Product updated successfully!');
        } else {
            Product::create([
                'title'       => $this->title,
                'category'    => $this->category,
                'description' => $this->description,
                'price'       => $this->price,
                'rating'      => $this->rating ?: 0,
                'is_active'   => $this->is_active,
                'image_path'  => $imagePath,
            ]);

            $this->dispatch('notify', message: 'Product created successfully!');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();
        $this->dispatch('notify', message: 'Product deleted.');
    }

    public function toggleActive(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);
        $this->dispatch('notify', message: 'Status updated.');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'description', 'price', 'image']);
        $this->category  = 'wattpad';
        $this->rating    = '0';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        $products = Product::when($this->search, fn($q) =>
            $q->where('title', 'like', '%' . $this->search . '%')
        )->latest()->paginate(10);

        return view('livewire.admin.admin-product-manager', compact('products'))
            ->layout('components.layout', ['title' => 'Admin — Products']);
    }
}
