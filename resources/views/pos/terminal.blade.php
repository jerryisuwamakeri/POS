@extends('layouts.app')

@section('title', 'POS Terminal')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-3 sm:p-4 md:p-6">
        <!-- Header -->
        <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-1 sm:mb-2">
                    POS Terminal
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium flex items-center space-x-2">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $branch->name }}</span>
                </p>
            </div>
            <a href="{{ route(dashboard_route()) }}" class="px-3 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 bg-white text-slate-700 rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all duration-200 font-semibold text-sm sm:text-base border border-slate-200 hover:border-slate-300 whitespace-nowrap">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
            <!-- Products List -->
            <div class="lg:col-span-2 bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg sm:shadow-xl md:shadow-2xl border border-slate-200/50 p-3 sm:p-4 md:p-6">
                <div class="mb-3 sm:mb-4 md:mb-6 space-y-2 sm:space-y-3 md:space-y-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="product-search" placeholder="Search products..." 
                               class="w-full pl-9 sm:pl-10 md:pl-12 pr-3 sm:pr-4 py-2 sm:py-2.5 md:py-3 text-sm sm:text-base border-2 border-slate-200 rounded-lg sm:rounded-xl focus:border-blue-500 focus:ring-2 sm:focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 placeholder-slate-400 font-medium">
                    </div>
                    <!-- Quantity Selector -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 rounded-lg sm:rounded-xl p-2 sm:p-3 md:p-4 border-2 border-blue-200 shadow-md">
                        <label class="text-xs sm:text-sm font-bold text-slate-700 whitespace-nowrap flex items-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Qty:
                        </label>
                        <div class="flex items-center space-x-1.5 sm:space-x-2">
                            <button type="button" id="qty-decrease" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white border-2 border-red-400 hover:from-red-600 hover:to-red-700 hover:border-red-500 flex items-center justify-center text-lg sm:text-xl md:text-2xl font-bold transition-all active:scale-90 shadow-md hover:shadow-lg touch-manipulation">
                                −
                            </button>
                            <input type="number" id="selected-quantity" value="1" min="1" max="999" 
                                   class="w-16 sm:w-20 md:w-24 text-center border-2 border-blue-300 rounded-lg sm:rounded-xl px-2 sm:px-3 py-1.5 sm:py-2 md:py-3 focus:border-blue-500 focus:ring-2 sm:focus:ring-4 focus:ring-blue-500/20 focus:outline-none transition-all text-slate-900 font-extrabold text-base sm:text-lg md:text-xl bg-white shadow-sm">
                            <button type="button" id="qty-increase" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white border-2 border-green-400 hover:from-green-600 hover:to-green-700 hover:border-green-500 flex items-center justify-center text-lg sm:text-xl md:text-2xl font-bold transition-all active:scale-90 shadow-md hover:shadow-lg touch-manipulation">
                                +
                            </button>
                        </div>
                        <p class="text-xs text-slate-600 font-semibold flex-1 bg-white/60 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 border border-slate-200">
                            📱 Select qty, tap product
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 overflow-y-auto custom-scrollbar" id="products-list" style="max-height: calc(100vh - 280px);">
                    @foreach($products as $product)
                    <div class="group border-2 border-slate-200 rounded-xl p-3 cursor-pointer hover:border-blue-500 hover:shadow-xl transition-all duration-200 product-item bg-white touch-manipulation select-none active:scale-95"
                         data-product-id="{{ $product->id }}"
                         data-product-name="{{ $product->name }}"
                         data-product-price="{{ $product->price }}"
                         data-product-stock="{{ $product->inventories->first()->qty ?? 0 }}">
                        <!-- Product Image -->
                        <div class="relative mb-2 aspect-square rounded-lg overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 group-hover:from-blue-50 group-hover:to-indigo-50 transition-all duration-200">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full flex items-center justify-center" style="display: none;">
                                    <svg class="w-12 h-12 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                            @if(($product->inventories->first()->qty ?? 0) <= 0)
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 text-xs font-bold bg-red-600 text-white rounded-full shadow-lg">Out</span>
                                </div>
                            @endif
                        </div>
                        <!-- Product Info -->
                        <div class="space-y-1">
                            <h3 class="font-bold text-slate-900 text-sm leading-tight line-clamp-2 min-h-[2.5rem]">{{ $product->name }}</h3>
                            <p class="text-base sm:text-lg font-extrabold bg-gradient-to-r from-brand-husk to-brand-teak bg-clip-text text-transparent">{{ format_money($product->price) }}</p>
                            <p class="text-xs text-slate-500 font-medium flex items-center">
                                <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>Stock: {{ $product->inventories->first()->qty ?? 0 }}</span>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Cart -->
            <div class="bg-gradient-to-br from-white to-slate-50 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg sm:shadow-xl md:shadow-2xl border border-slate-200/50 p-3 sm:p-4 md:p-6 sticky top-3 sm:top-4 md:top-6">
                <div class="flex items-center space-x-2 mb-2 sm:mb-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900">Cart</h2>
                </div>
                <div id="cart-items" class="mb-3 sm:mb-4 md:mb-6 max-h-[250px] sm:max-h-[300px] md:max-h-[350px] overflow-y-auto custom-scrollbar">
                    <p class="text-slate-400 text-center py-6 sm:py-8 md:py-12 text-sm sm:text-base font-medium">No items in cart</p>
                </div>
                <div class="border-t-2 border-slate-200 pt-3 sm:pt-4 md:pt-6 mt-3 sm:mt-4 md:mt-6 space-y-2 sm:space-y-3">
                    <div class="flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg sm:rounded-xl p-2 sm:p-3 md:p-4 border border-blue-100">
                        <span class="text-sm sm:text-base md:text-lg font-bold text-slate-700">Total:</span>
                        <span class="text-xl sm:text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-brand-husk to-brand-teak bg-clip-text text-transparent" id="cart-total">₦0.00</span>
                    </div>
                    <div class="space-y-2 sm:space-y-2.5 md:space-y-3">
                        <!-- Customer Selection -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1 sm:mb-2">Customer</label>
                            <select id="customer-select" 
                                    class="w-full border-2 border-slate-200 rounded-lg sm:rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 text-sm sm:text-base focus:border-blue-500 focus:ring-2 sm:focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                                <option value="">Walk-in</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" 
                                            data-name="{{ $customer->name }}"
                                            data-contact="{{ $customer->email ?? $customer->phone ?? '' }}">
                                        {{ $customer->name }}@if($customer->email || $customer->phone) - {{ $customer->email ?? $customer->phone }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" id="customer-id" value="">
                        </div>
                        <select id="payment-method" class="w-full border-2 border-slate-200 rounded-lg sm:rounded-xl px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 text-sm sm:text-base focus:border-blue-500 focus:ring-2 sm:focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="wallet">Wallet</option>
                            <option value="pos">POS</option>
                        </select>
                        <button id="checkout-btn" class="w-full bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki text-white px-4 sm:px-6 py-2.5 sm:py-3 md:py-4 rounded-lg sm:rounded-xl hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all transform hover:scale-[1.02] font-bold text-sm sm:text-base md:text-lg shadow-lg sm:shadow-xl hover:shadow-2xl border border-blue-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Checkout
                        </button>
                        <button id="clear-cart-btn" class="w-full bg-slate-100 text-slate-700 px-4 sm:px-6 py-2 sm:py-2.5 md:py-3 rounded-lg sm:rounded-xl hover:bg-slate-200 transition-all font-semibold text-sm sm:text-base border border-slate-200">
                            Clear
                        </button>
                        <button onclick="document.getElementById('calculator-modal').classList.remove('hidden')" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 sm:px-6 py-2 sm:py-2.5 md:py-3 rounded-lg sm:rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold text-sm sm:text-base shadow-md sm:shadow-lg hover:shadow-xl">
                            🧮 Calc
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculator Modal -->
    <div id="calculator-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 transform transition-all shadow-2xl border border-slate-200 animate-scale-in">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg sm:text-xl font-bold text-slate-900">Calculator</h3>
                <button onclick="document.getElementById('calculator-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <input type="text" id="calc-display" readonly value="0" class="w-full text-right text-4xl font-bold text-slate-900 bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-6 focus:outline-none">
            </div>
            <div class="grid grid-cols-4 gap-3">
                <button onclick="calcClear()" class="col-span-2 bg-red-500 text-white px-4 py-4 rounded-xl hover:bg-red-600 transition-all font-bold shadow-lg">Clear</button>
                <button onclick="calcSetOperation('/')" class="bg-blue-500 text-white px-4 py-4 rounded-xl hover:bg-blue-600 transition-all font-bold shadow-lg">/</button>
                <button onclick="calcSetOperation('*')" class="bg-blue-500 text-white px-4 py-4 rounded-xl hover:bg-blue-600 transition-all font-bold shadow-lg">×</button>
                
                <button onclick="calcNumber('7')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">7</button>
                <button onclick="calcNumber('8')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">8</button>
                <button onclick="calcNumber('9')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">9</button>
                <button onclick="calcSetOperation('-')" class="bg-blue-500 text-white px-4 py-4 rounded-xl hover:bg-blue-600 transition-all font-bold shadow-lg">-</button>
                
                <button onclick="calcNumber('4')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">4</button>
                <button onclick="calcNumber('5')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">5</button>
                <button onclick="calcNumber('6')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">6</button>
                <button onclick="calcSetOperation('+')" class="bg-blue-500 text-white px-4 py-4 rounded-xl hover:bg-blue-600 transition-all font-bold shadow-lg">+</button>
                
                <button onclick="calcNumber('1')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">1</button>
                <button onclick="calcNumber('2')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">2</button>
                <button onclick="calcNumber('3')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">3</button>
                <button onclick="calcEquals()" class="row-span-2 bg-gradient-to-br from-green-500 to-emerald-600 text-white px-4 py-8 rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all font-bold shadow-lg">=</button>
                
                <button onclick="calcNumber('0')" class="col-span-2 bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">0</button>
                <button onclick="calcNumber('.')" class="bg-slate-200 text-slate-900 px-4 py-4 rounded-xl hover:bg-slate-300 transition-all font-bold">.</button>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 transform transition-all shadow-2xl border border-slate-200">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 mb-6 shadow-lg">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-3">Order Successful!</h3>
            <p class="text-slate-600 mb-8 font-medium text-lg" id="order-reference"></p>
            <div class="flex gap-3">
                <button id="print-receipt-btn" class="flex-1 bg-gradient-to-r from-brand-husk to-brand-teak text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Receipt
                </button>
                <button id="close-modal-btn" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let cart = [];
let currentOrder = null;
let selectedQuantity = 1;

// Calculator variables
let calcValue = '0';
let calcOperation = null;
let calcWaitingForOperand = false;
let calcPrevValue = 0;

// Calculator Functions (must be global for onclick handlers)
function calcUpdateDisplay() {
    const display = document.getElementById('calc-display');
    if (display) {
        display.value = calcValue;
    }
}

function calcNumber(num) {
    if (calcWaitingForOperand) {
        calcValue = num;
        calcWaitingForOperand = false;
    } else {
        calcValue = calcValue === '0' ? num : calcValue + num;
    }
    calcUpdateDisplay();
}

function calcSetOperation(op) {
    const inputValue = parseFloat(calcValue);

    if (calcOperation === null) {
        calcPrevValue = inputValue;
        calcOperation = op;
        calcWaitingForOperand = true;
    } else {
        if (!calcWaitingForOperand) {
            const result = calcPerformCalculation();
            calcValue = String(result);
            calcPrevValue = result;
        }
        calcOperation = op;
        calcWaitingForOperand = true;
    }
    calcUpdateDisplay();
}

function calcPerformCalculation() {
    const inputValue = parseFloat(calcValue);
    let result = inputValue;

    if (calcOperation === '+') {
        result = calcPrevValue + inputValue;
    } else if (calcOperation === '-') {
        result = calcPrevValue - inputValue;
    } else if (calcOperation === '*') {
        result = calcPrevValue * inputValue;
    } else if (calcOperation === '/') {
        result = inputValue !== 0 ? calcPrevValue / inputValue : 0;
    }
    
    // Round to avoid floating point errors
    return Math.round(result * 100) / 100;
}

function calcEquals() {
    if (calcOperation !== null) {
        const result = calcPerformCalculation();
        calcValue = String(result);
        calcOperation = null;
        calcPrevValue = 0;
        calcWaitingForOperand = true;
        calcUpdateDisplay();
    }
}

function calcClear() {
    calcValue = '0';
    calcOperation = null;
    calcPrevValue = 0;
    calcWaitingForOperand = false;
    calcUpdateDisplay();
}

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize calculator display
    calcUpdateDisplay();
    // Product search
    const productSearch = document.getElementById('product-search');
    if (productSearch) {
        productSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                const productName = item.dataset.productName.toLowerCase();
                item.style.display = productName.includes(searchTerm) ? 'block' : 'none';
            });
        });
    }

    // Customer selection
    const customerSelect = document.getElementById('customer-select');
    const customerIdInput = document.getElementById('customer-id');

    if (customerSelect && customerIdInput) {
        customerSelect.addEventListener('change', function() {
            if (this.value) {
                customerIdInput.value = this.value;
            } else {
                customerIdInput.value = '';
            }
        });
    }

    // Quantity selector
    const quantityInput = document.getElementById('selected-quantity');
    const qtyIncreaseBtn = document.getElementById('qty-increase');
    const qtyDecreaseBtn = document.getElementById('qty-decrease');

    if (quantityInput) {
        // Update selected quantity variable
        quantityInput.addEventListener('input', function() {
            let value = parseInt(this.value) || 1;
            if (value < 1) value = 1;
            if (value > 999) value = 999;
            this.value = value;
            selectedQuantity = value;
        });

        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value) || 1;
            if (value < 1) value = 1;
            if (value > 999) value = 999;
            this.value = value;
            selectedQuantity = value;
        });
    }

    // Increase quantity
    if (qtyIncreaseBtn && quantityInput) {
        qtyIncreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue < 999) {
                currentValue++;
                quantityInput.value = currentValue;
                selectedQuantity = currentValue;
                quantityInput.dispatchEvent(new Event('input'));
            }
        });
        
        // Also support touch events
        qtyIncreaseBtn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue < 999) {
                currentValue++;
                quantityInput.value = currentValue;
                selectedQuantity = currentValue;
                quantityInput.dispatchEvent(new Event('input'));
            }
        });
    }

    // Decrease quantity
    if (qtyDecreaseBtn && quantityInput) {
        qtyDecreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                currentValue--;
                quantityInput.value = currentValue;
                selectedQuantity = currentValue;
                quantityInput.dispatchEvent(new Event('input'));
            }
        });
        
        // Also support touch events
        qtyDecreaseBtn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                currentValue--;
                quantityInput.value = currentValue;
                selectedQuantity = currentValue;
                quantityInput.dispatchEvent(new Event('input'));
            }
        });
    }

    // Add to cart - works with both click and touch
    let lastTouchTime = 0;
    
    function attachProductListeners() {
        document.querySelectorAll('.product-item').forEach(item => {
            // Avoid duplicate bindings
            if (item.dataset.bound === '1') return;
            item.dataset.bound = '1';

            // Handle touch
            item.addEventListener('touchend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                lastTouchTime = Date.now();
                addProductToCart(this);
            });
            
            // Handle click (for desktop) - ignore if it was a touch event
            item.addEventListener('click', function(e) {
                // Ignore clicks that happen right after touch (within 300ms)
                if (Date.now() - lastTouchTime < 300) {
                    return;
                }
                e.preventDefault();
                e.stopPropagation();
                addProductToCart(this);
            });
        });
    }
    
    // Attach listeners when DOM is ready
    attachProductListeners();
    
    function addProductToCart(element) {
        if (!element) {
            console.error('Product element not found');
            return;
        }
        
        const productId = parseInt(element.dataset.productId);
        const productName = element.dataset.productName;
        const productPrice = parseInt(element.dataset.productPrice);
        const stock = parseInt(element.dataset.productStock);
        const qty = selectedQuantity || 1;

        // Validation
        if (isNaN(productId) || !productName || isNaN(productPrice)) {
            console.error('Invalid product data', { productId, productName, productPrice });
            showNotification('Invalid product data', 'error');
            return;
        }

        if (isNaN(stock) || stock < 0) {
            console.error('Invalid stock data', stock);
            showNotification('Invalid stock information', 'error');
            return;
        }

        if (stock <= 0) {
            showNotification('Product out of stock', 'error');
            return;
        }

        if (qty <= 0 || qty > 999) {
            showNotification('Invalid quantity', 'error');
            return;
        }

        if (qty > stock) {
            showNotification(`Only ${stock} available in stock`, 'error');
            return;
        }

        const existingItem = cart.find(item => item.product_id === productId);
        if (existingItem) {
            const newTotalQty = existingItem.qty + qty;
            if (newTotalQty > stock) {
                showNotification(`Cannot add ${qty}. Only ${stock - existingItem.qty} more available`, 'error');
                return;
            }
            existingItem.qty += qty;
        } else {
            cart.push({
                product_id: productId,
                product_name: productName,
                qty: qty,
                unit_price: productPrice
            });
        }

        updateCartDisplay();
        
        // Visual feedback
        element.style.transform = 'scale(0.95)';
        element.style.opacity = '0.8';
        setTimeout(() => {
            element.style.transform = '';
            element.style.opacity = '1';
        }, 200);
        
        showNotification(`${qty}x ${productName} added to cart`, 'success');
    }
    
    // Clear cart
    const clearCartBtn = document.getElementById('clear-cart-btn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (cart.length === 0) return;
            if (confirm('Clear all items from cart?')) {
                cart = [];
                updateCartDisplay();
                if (customerSelect) customerSelect.value = '';
                if (customerIdInput) customerIdInput.value = '';
            }
        });
        
        // Touch support
        clearCartBtn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (cart.length === 0) return;
            if (confirm('Clear all items from cart?')) {
                cart = [];
                updateCartDisplay();
                if (customerSelect) customerSelect.value = '';
                if (customerIdInput) customerIdInput.value = '';
            }
        });
    }
    
    // Checkout
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        const performCheckout = function(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            if (cart.length === 0) {
                showNotification('Cart is empty', 'error');
                return;
            }

            const btn = checkoutBtn;
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Processing...';

            const customerId = customerIdInput ? customerIdInput.value : '';
            const paymentMethodEl = document.getElementById('payment-method');
            const paymentMethod = paymentMethodEl ? paymentMethodEl.value : 'cash';

            fetch('{{ route("pos.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    items: cart,
                    customer_id: customerId || null,
                    payment_method: paymentMethod
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.error || 'Checkout failed');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    currentOrder = {
                        ...data.order,
                        receipt_url: data.receipt_url
                    };
                    const orderRefEl = document.getElementById('order-reference');
                    const successModal = document.getElementById('success-modal');
                    if (orderRefEl) {
                        orderRefEl.textContent = 'Order #' + data.order.reference;
                    }
                    if (successModal) {
                        successModal.classList.remove('hidden');
                    }
                    cart = [];
                    updateCartDisplay();
                    if (customerSelect) {
                        customerSelect.value = '';
                        if (customerIdInput) customerIdInput.value = '';
                    }
                } else {
                    showNotification(data.error || 'Checkout failed', 'error');
                }
                btn.disabled = false;
                btn.textContent = originalText;
            })
            .catch(error => {
                console.error('Checkout error:', error);
                showNotification(error.message || 'An error occurred during checkout', 'error');
                btn.disabled = false;
                btn.textContent = originalText;
            });
        };
        
        checkoutBtn.addEventListener('click', performCheckout);
        
        // Touch support
        checkoutBtn.addEventListener('touchend', function(e) {
            e.preventDefault();
            performCheckout(e);
        });
    }
    
    // Print receipt
    const printReceiptBtn = document.getElementById('print-receipt-btn');
    if (printReceiptBtn) {
        printReceiptBtn.addEventListener('click', function() {
            if (currentOrder && currentOrder.receipt_url) {
                // Use the printReceipt function if available, otherwise implement inline
                if (typeof window.printReceipt === 'function') {
                    window.printReceipt(currentOrder.receipt_url);
                } else {
                    // Fallback: open receipt and trigger print
                    const printWindow = window.open(currentOrder.receipt_url, '_blank');
                    
                    if (printWindow) {
                        // Wait for window to load, then trigger print
                        const tryPrint = function() {
                            try {
                                if (printWindow.document.readyState === 'complete') {
                                    printWindow.focus();
                                    printWindow.print();
                                } else {
                                    setTimeout(tryPrint, 100);
                                }
                            } catch (e) {
                                console.error('Print error:', e);
                                // If print fails, at least the receipt is open for manual printing
                            }
                        };
                        
                        // Start trying to print after a short delay
                        setTimeout(tryPrint, 500);
                        
                        // Fallback: try print after longer delay
                        setTimeout(function() {
                            if (printWindow && !printWindow.closed) {
                                try {
                                    printWindow.focus();
                                    printWindow.print();
                                } catch (e) {
                                    console.error('Print error:', e);
                                }
                            }
                        }, 1500);
                    }
                }
            } else {
                showNotification('No receipt available', 'error');
            }
        });
    }

    // Close modal
    const closeModalBtn = document.getElementById('close-modal-btn');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            document.getElementById('success-modal').classList.add('hidden');
            currentOrder = null;
        });
    }
    
    // Initialize calculator display
    calcUpdateDisplay();
});

function updateCartDisplay() {
    const cartItemsDiv = document.getElementById('cart-items');
    const cartTotalDiv = document.getElementById('cart-total');
    
    if (!cartItemsDiv || !cartTotalDiv) {
        console.error('Cart display elements not found');
        return;
    }
    
    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="text-slate-400 text-center py-6 sm:py-8 md:py-12 text-sm sm:text-base font-medium">No items in cart</p>';
        cartTotalDiv.textContent = '₦0.00';
        return;
    }

    let total = 0;
    let html = '<div class="space-y-2 sm:space-y-2.5">';
    
    cart.forEach((item, index) => {
        const itemTotal = item.qty * item.unit_price;
        total += itemTotal;
        html += `
            <div class="flex justify-between items-center p-2 sm:p-2.5 md:p-3 bg-gradient-to-r from-slate-50 to-blue-50/30 rounded-lg sm:rounded-xl border border-slate-200 hover:border-blue-300 transition-all" data-cart-index="${index}">
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-slate-900 text-xs sm:text-sm mb-1 sm:mb-1.5 truncate">${escapeHtml(item.product_name)}</p>
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <button type="button" class="cart-qty-decrease w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 rounded-md sm:rounded-lg bg-white border-2 border-slate-200 hover:border-blue-500 hover:bg-blue-50 flex items-center justify-center text-xs sm:text-sm font-bold text-slate-700 hover:text-blue-600 transition-all touch-manipulation min-w-[24px] min-h-[24px]" data-index="${index}">−</button>
                        <span class="text-xs sm:text-sm md:text-base font-extrabold text-slate-900 w-6 sm:w-8 text-center">${item.qty}</span>
                        <button type="button" class="cart-qty-increase w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 rounded-md sm:rounded-lg bg-white border-2 border-slate-200 hover:border-blue-500 hover:bg-blue-50 flex items-center justify-center text-xs sm:text-sm font-bold text-slate-700 hover:text-blue-600 transition-all touch-manipulation min-w-[24px] min-h-[24px]" data-index="${index}">+</button>
                    </div>
                </div>
                <div class="text-right ml-2 sm:ml-3 flex-shrink-0">
                    <p class="font-extrabold text-sm sm:text-base md:text-lg text-slate-900 mb-1">₦${(itemTotal / 100).toFixed(2)}</p>
                    <button type="button" class="cart-remove text-red-600 hover:text-red-700 text-[10px] sm:text-xs font-semibold hover:underline transition-colors touch-manipulation" data-index="${index}">Remove</button>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    cartItemsDiv.innerHTML = html;
    cartTotalDiv.textContent = '₦' + (total / 100).toFixed(2);
    
    // Attach event listeners to cart buttons
    attachCartListeners();
}

// Helper function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Attach event listeners to cart item buttons
function attachCartListeners() {
    // Quantity decrease buttons
    document.querySelectorAll('.cart-qty-decrease').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = parseInt(this.dataset.index);
            if (index >= 0 && index < cart.length) {
                cart[index].qty -= 1;
                if (cart[index].qty <= 0) {
                    cart.splice(index, 1);
                }
                updateCartDisplay();
            }
        });
        
        // Touch support
        btn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = parseInt(this.dataset.index);
            if (index >= 0 && index < cart.length) {
                cart[index].qty -= 1;
                if (cart[index].qty <= 0) {
                    cart.splice(index, 1);
                }
                updateCartDisplay();
            }
        });
    });
    
    // Quantity increase buttons
    document.querySelectorAll('.cart-qty-increase').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = parseInt(this.dataset.index);
            if (index >= 0 && index < cart.length) {
                cart[index].qty += 1;
                updateCartDisplay();
            }
        });
        
        // Touch support
        btn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = parseInt(this.dataset.index);
            if (index >= 0 && index < cart.length) {
                cart[index].qty += 1;
                updateCartDisplay();
            }
        });
    });
    
    // Remove buttons
    document.querySelectorAll('.cart-remove').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = parseInt(this.dataset.index);
            if (index >= 0 && index < cart.length) {
                cart.splice(index, 1);
                updateCartDisplay();
            }
        });
        
        // Touch support
        btn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = parseInt(this.dataset.index);
            if (index >= 0 && index < cart.length) {
                cart.splice(index, 1);
                updateCartDisplay();
            }
        });
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-xl shadow-2xl z-50 flex items-center space-x-3 animate-slide-in border ${
        type === 'success' 
            ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white border-green-400/20' 
            : 'bg-gradient-to-r from-red-500 to-rose-600 text-white border-red-400/20'
    }`;
    
    const icon = type === 'success' 
        ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
        : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    
    notification.innerHTML = `<div class="flex-shrink-0">${icon}</div><span class="font-semibold">${message}</span>`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

</script>
@endsection
