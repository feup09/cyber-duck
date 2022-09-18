<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-x-2 gap-y-2" x-data="greet()">
                        <div>
                            <x-label>Quantity</x-label>
                            <x-input name="quantity" type="number" x-model="quantity"
                                @input.debounce="calculateSellingPrice()"></x-input>
                        </div>
                        <div>
                            <x-label x-text="`Unit Cost ${currency}`">Unit Cost</x-label>
                            <x-input name="unit-cost" type="number" step="0.01" x-model="unitCost"
                                @input.debounce="calculateSellingPrice()">
                            </x-input>
                        </div>
                        <div>
                            <x-label>Selling Price</x-label>
                            <div class="px-3 py-2" x-text="sellingPrice"></div>
                        </div>
                        <div class="flex items-end">
                            {{-- <x-button>Record Sale</x-button> --}}
                        </div>

                        <template x-if="errorMessage">
                            <div class="bg-red-500 col-span-1 md:col-span-2 text-white mt-4 p-2 text-xs rounded"
                                x-text="errorMessage"></div>
                        </template>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const currency = '£';


    function greet() {
        return {
            currency: currency,
            quantity: 0,
            unitCost: 0,
            sellingPrice: currency + '--.--',
            errorMessage: null,
            calculateSellingPrice() {
                axios.get('/sales/get-selling-price', {
                        params: {
                            quantity: this.quantity,
                            unitCost: this.unitCost,
                        }
                    }).then(res => {
                        this.errorMessage = null
                        this.sellingPrice = `${currency}${res.data.sellingPrice}`
                    })
                    .catch(error => {
                        this.sellingPrice = currency + '--.--'
                        this.errorMessage = error.response.data.message
                    })
            }
        }
    }
</script>
