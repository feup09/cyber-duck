<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="sales()">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-x-2 gap-y-2">
                        <div>
                            <x-label>{{ __('Quantity') }}</x-label>
                            <x-input name="quantity" type="number" x-model="quantity"
                                @input.debounce="calculateSellingPrice()"></x-input>
                        </div>
                        <div>
                            <x-label x-text="`Unit Cost ${currency}`">{{ __('Unit Cost') }}</x-label>
                            <x-input name="unit-cost" type="number" step="0.01" x-model="unitCost"
                                @input.debounce="calculateSellingPrice()">
                            </x-input>
                        </div>
                        <div>
                            <x-label> {{ __('Selling Price') }}</x-label>
                            <div class="px-3 py-2" x-text="sellingPrice"></div>
                        </div>
                        <div class="flex items-end">
                            <x-button @click="recordSale()"> {{ __('Record Sale') }}</x-button>
                        </div>

                        <template x-if="errorMessage">
                            <div class="bg-red-500 col-span-1 md:col-span-2 text-white mt-4 p-2 text-xs rounded"
                                x-text="errorMessage"></div>
                        </template>

                    </div>

                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Previous Sales') }}
                    </h2>
                    <div class="mt-8 max-h-96 overflow-y-auto">
                        <x-table x-init="getSales()">
                            <thead class="bg-gray-50">
                                <tr>
                                    <x-th>{{ __('Quantity') }}</x-th>
                                    <x-th>{{ __('Unit Cost') }}</x-th>
                                    <x-th>{{ __('Selling Price') }}</x-th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="sale in sales">
                                    <tr>
                                        <x-td x-text="sale.quantity"></x-td>
                                        <x-td x-text="`${currency}${sale.unit_cost}`"></x-td>
                                        <x-td x-text="`${currency}${sale.selling_price}`"></x-td>
                                    </tr>
                                </template>

                            </tbody>
                        </x-table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const currency = '£';


    function sales() {
        return {
            currency: currency,
            quantity: 0,
            unitCost: 0,
            sellingPrice: currency + '--.--',
            canRecord: false,
            errorMessage: null,
            sales: [],
            resetCalculator() {
                this.quantity = 0
                this.unitCost = 0
                this.sellingPrice = currency + '--.--'
                this.canRecord = false
            },
            getSales() {
                axios.get('/sales/get-sales').then(res => {
                        this.sales = res.data.sales
                    })
                    .catch(error => {

                    })
            },
            calculateSellingPrice() {
                axios.get('/sales/get-selling-price', {
                        params: {
                            quantity: this.quantity,
                            unitCost: this.unitCost,
                        }
                    }).then(res => {
                        this.errorMessage = null
                        this.sellingPrice = `${currency}${res.data.sellingPrice}`
                        this.canRecord = true
                    })
                    .catch(error => {
                        this.sellingPrice = currency + '--.--'
                        this.errorMessage = error.response.data.message
                        this.canRecord = false

                    })
            },
            recordSale() {
                if (!this.canRecord) {
                    return
                }
                axios.post('/sales', {
                        quantity: this.quantity,
                        unitCost: this.unitCost,

                    }).then(res => {
                        this.resetCalculator()
                        this.getSales()
                    })
                    .catch(error => {

                    })


            }
        }
    }
</script>
