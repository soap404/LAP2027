<?php

use App\Models\Product;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')]
class extends Component {

    public array $products = [];


    public function mount(): void
    {
        $this->products = Product::all()->toArray();

    }
}
?>
<section>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Produkte</h1>

        <a href="{{ route('products.products') }}" wire:navigate
           class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            + Neues Produkt
        </a>
    </div>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @forelse ($products as $product)
            <div wire:key="product-{{ $product['id'] }}"
                 class="flex flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                @if ($product['img_path'])
                    <img src="{{ asset('storage/' . $product['img_path']) }}"
                         alt="{{ $product['name'] }}"
                         class="aspect-square w-full object-cover">
                @else
                    <div
                        class="flex aspect-square items-center justify-center bg-zinc-100 text-sm text-zinc-400 dark:bg-zinc-800">
                        Kein Bild
                    </div>
                @endif

                <div class="flex flex-1 flex-col p-4">
                    <div class="flex items-start justify-between gap-2">
                        <h2 class="font-semibold text-zinc-900 dark:text-white">{{ $product['name'] }}</h2>

                        @unless ($product['is_active'])
                            <span
                                class="shrink-0 rounded-full bg-zinc-200 px-2 py-0.5 text-xs text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">
                                Inaktiv
                            </span>
                        @endunless
                    </div>

                    @if ($product['description'])
                        <p class="mt-1 line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $product['description'] }}
                        </p>
                    @endif

                    <div class="mt-auto flex items-center justify-between pt-4">
                        <span class="text-lg font-bold text-zinc-900 dark:text-white">
                            {{ number_format($product['price'], 2, ',', '.') }} €
                        </span>

                        @if ($product['quantity'] > 0)
                            <span class="text-sm text-green-600 dark:text-green-400">{{ $product['quantity'] }} auf Lager</span>
                        @else
                            <span class="text-sm text-red-600 dark:text-red-400">Ausverkauft</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full py-12 text-center text-zinc-500">Keine Produkte vorhanden.</p>
        @endforelse
    </div>
</section>
