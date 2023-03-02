<?php

namespace App\Http\Livewire\Agent;

use App\Enums\ProductProvider;
use App\Models\Product;
use App\Services\Envato\Client;
use App\Settings\EnvatoSettings;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Livewire\WithPagination;

class ProductManager extends Component
{
    use WithPagination;

    public $search;
    public $product;
    public $showProductForm = false;
    public $envatoProducts = [];
    public $showEnvatoModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected function rules()
    {
        return [
            'product.provider' => ['required', new Enum(ProductProvider::class)],
            'product.name' => 'required|string|max:255',
            'product.code' => 'nullable|string|unique:products,code',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createProduct()
    {
        $this->product = new Product([
            'provider' => ProductProvider::SELF_HOSTED->name,
        ]);
        $this->showProductForm = true;
    }

    public function saveProduct()
    {
        $this->validate([
            'product.name' => 'required|string|max:255',
            'product.code' => 'required|string|unique:products,code,' . $this->product->id,
        ]);
        $this->product->save();
        $this->dispatchBrowserEvent('notify', $this->product->wasRecentlyCreated ? trans('Product has been created.') : trans('Product has been updated.'));
        $this->reset('product', 'showProductForm');
    }

    public function editProduct(Product $product)
    {
        $this->product = $product;
        $this->showProductForm = true;
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        $this->reset('product', 'showProductForm');
        $this->notify(trans('Product has been removed.'));
    }

    public function toggleSupport(Product $product)
    {
        $product->disabled_at = $product->is_disabled ? null : now()->toDateTimeString();
        $product->save();
    }

    public function loadEnvatoProducts(Client $client)
    {
        $this->reset('envatoProducts');

        $envatoSites = ['themeforest', 'codecanyon', 'videohive', 'audiojungle', 'graphicriver', 'photodune', '3docean', 'activeden'];

        try {
            foreach ($envatoSites as $site) {
                $response = $client->getNewItems($this->envatoSettings->account_token, $this->envatoSettings->account_username, $site);
                $this->envatoProducts = array_merge($this->envatoProducts, $response['new-files-from-user']);
            }
        } catch (\Exception $e) {
            $this->addError('envato', $e->getMessage());
        }
    }

    public function addProduct($index)
    {
        $product = new Product([
            'provider' => ProductProvider::ENVATO->name,
            'name' => $this->envatoProducts[$index]['item'],
            'code' => $this->envatoProducts[$index]['id'],
        ]);

        $product->save();

        $product->addMediaFromUrl($this->envatoProducts[$index]['thumbnail'])->toMediaCollection('logo');

        $this->notify(trans('New product has been added.'));
    }

    public function getProductsProperty()
    {
        return Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount('tickets')
            ->latest()
            ->paginate(10);
    }

    public function getEnvatoSettingsProperty()
    {
        return app(EnvatoSettings::class);
    }

    public function render()
    {
        return view('livewire.agent.product-manager');
    }
}
