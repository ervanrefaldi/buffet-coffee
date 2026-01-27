<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $product->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#FDF8F5',
                        brown: { DEFAULT: '#4A3427', dark: '#2C1E17', light: '#705446' },
                        gold: '#C5A358'
                    },
                    fontFamily: { serif: ['Playfair Display', 'serif'], sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-cream font-sans text-brown min-h-screen flex flex-col">

    <nav class="bg-white shadow-sm py-4">
        <div class="max-w-3xl mx-auto px-6 flex justify-between items-center">
            <a href="{{ url('/menu') }}" class="text-xs font-bold uppercase tracking-widest hover:text-gold transition">
                ← Kembali ke Menu
            </a>
            <img src="/{{ ('images/logo.png') }}" class="h-8 w-auto brightness-0 invert">
        </div>
    </nav>

    <main class="flex-grow max-w-3xl mx-auto px-6 py-12 w-full">
        
        <div class="bg-white rounded-[2rem] shadow-lg overflow-hidden border border-brown/5">
            <div class="p-4 md:p-12">
                
                <h1 class="text-3xl font-serif font-bold text-center mb-8">Konfirmasi Pesanan</h1>

                <div class="mb-10">
                    <div id="items-container" class="space-y-6 mb-6">
                        <!-- Initial Product is handled by JS -->
                    </div>
                    
                    <button type="button" onclick="openProductModal()" class="w-full py-4 border-2 border-dashed border-brown/20 rounded-2xl text-brown/60 text-sm font-bold hover:border-gold hover:text-gold hover:bg-gold/5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Produk Lain
                    </button>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm" target="_blank" onsubmit="setTimeout(() => window.location.href='/orders', 1000)">
                    @csrf
                    <div id="hidden-inputs-container"></div>
                    
                    <!-- Customer Details -->
                    <div class="space-y-4 mb-8">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest mb-2 text-brown/60">Nama Pemesan</label>
                            <input type="text" value="{{ $user->name }}" readonly class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold text-gray-500 cursor-not-allowed">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest mb-2 text-brown/60">Nomor Telepon (Sesuai Profile)</label>
                                <input type="tel" name="phone" value="{{ $user->phone }}" required 
                                       class="w-full bg-white border border-brown/20 rounded-xl px-4 py-3 text-sm focus:border-gold focus:ring-gold transition mb-2">
                                <p class="text-[10px] text-brown/40 italic">*Ubah nomor telepon jika berbeda</p>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest mb-2 text-brown/60">Alamat Pengiriman</label>
                                <textarea name="address" rows="1" required placeholder="Jalan..." class="w-full bg-white border border-brown/20 rounded-xl px-4 py-3 text-sm focus:border-gold focus:ring-gold transition"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <div id="summary-items" class="space-y-2 mb-4 text-sm">
                            <!-- Items summation here -->
                        </div>
                        <div class="h-px w-full bg-gray-200 my-4"></div>
                        @if($isMember)
                        <div class="flex justify-between items-center mb-2 text-sm text-green-600">
                            <span>Diskon Member (3%)</span>
                            <span class="font-bold">- <span id="discountAmount">Rp 0</span></span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-bold text-brown">Total Pembayaran</span>
                            <span class="font-black text-gold text-2xl" id="totalPrice">Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <button type="submit" class="w-full py-4 bg-brown text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gold hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Konfirmasi Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Product Picker Modal -->
    <div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-900/50 transition-opacity" onclick="closeProductModal()"></div>
            
            <div class="relative bg-white rounded-3xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-xl font-serif font-bold text-brown">Pilih Produk</h3>
                    <button onclick="closeProductModal()" class="text-gray-400 hover:text-brown transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-8 max-h-[60vh] overflow-y-auto space-y-4">
                    @foreach($allProducts as $p)
                    <div class="flex items-center gap-6 p-4 rounded-2xl hover:bg-cream transition group border border-transparent hover:border-gold/20">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                            @if($p->image)
                                <img src="/{{ $p->image }}" class="object-cover w-full h-full"
                                     onerror="this.onerror=null; this.src='/images/logo.png'; this.classList.add('opacity-10','grayscale');">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-2xl">☕</div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h4 class="font-bold text-brown group-hover:text-gold transition">{{ $p->name }}</h4>
                            <div class="text-[10px] text-brown/60 flex gap-2">
                                <span>200g: {{ $p->stock_200g }}</span> | 
                                <span>500g: {{ $p->stock_500g }}</span> | 
                                <span>1kg: {{ $p->stock_1kg }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                             <select id="variant-{{ $p->products_id }}" class="text-[10px] font-bold uppercase tracking-widest bg-white border border-brown/10 rounded-lg px-2 py-1 outline-none">
                                <option value="200g">200g</option>
                                <option value="500g">500g</option>
                                <option value="1kg">1kg</option>
                            </select>
                            <button onclick="addItem('{{ $p->products_id }}', '{{ $p->name }}', '/{{ $p->image ?? '' }}', {{ $p->price_200g }}, {{ $p->price_500g }}, {{ $p->price_1kg }}, {{ $p->stock_200g }}, {{ $p->stock_500g }}, {{ $p->stock_1kg }})" 
                                    class="px-4 py-2 bg-brown text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gold transition-colors">
                                Tambah
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        const isMember = {{ $isMember ? 'true' : 'false' }};
        const discountRate = 0.03;
        let items = [
            {
                id: '{{ $product->products_id }}',
                name: '{{ $product->name }}',
                image: '/{{ $product->image ?? "" }}',
                variant: '{{ request("variant", "200g") }}',
                quantity: 1,
                prices: {
                    '200g': {{ $product->price_200g }},
                    '500g': {{ $product->price_500g }},
                    '1kg':  {{ $product->price_1kg }}
                },
                stocks: {
                    '200g': {{ $product->stock_200g }},
                    '500g': {{ $product->stock_500g }},
                    '1kg':  {{ $product->stock_1kg }}
                }
            }
        ];

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        function openProductModal() {
            document.getElementById('productModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function addItem(id, name, image, p200, p500, p1000, s200, s500, s1000) {
            const variantSelect = document.getElementById(`variant-${id}`);
            const variant = variantSelect.value;
            
            // Check if item already exists with same variant
            const existing = items.find(i => i.id === id && i.variant === variant);
            if (existing) {
                existing.quantity++;
            } else {
                items.push({
                    id, name, image, variant,
                    quantity: 1,
                    prices: { '200g': p200, '500g': p500, '1kg': p1000 },
                    stocks: { '200g': s200, '500g': s500, '1kg': s1000 }
                });
            }
            render();
            closeProductModal();
        }

        function removeItem(index) {
            items.splice(index, 1);
            render();
        }

        function updateQty(index, change) {
            const item = items[index];
            const maxQty = item.stocks[item.variant];
            
            let next = item.quantity + change;
            if (next >= 1 && next <= maxQty) {
                item.quantity = next;
                render();
            }
        }

        function render() {
            const container = document.getElementById('items-container');
            const hiddenContainer = document.getElementById('hidden-inputs-container');
            const summaryContainer = document.getElementById('summary-items');
            
            container.innerHTML = '';
            hiddenContainer.innerHTML = '';
            summaryContainer.innerHTML = '';
            
            let subtotal = 0;
            let totalWeight = 0;

            items.forEach((item, index) => {
                const itemPrice = item.prices[item.variant];
                const itemSubtotal = itemPrice * item.quantity;
                subtotal += itemSubtotal;
                
                // HTML for row
                const row = `
                    <div class="flex flex-col md:flex-row gap-6 p-6 bg-cream/30 rounded-3xl border border-brown/5 relative group">
                        ${items.length > 1 ? `
                            <button type="button" onclick="removeItem(${index})" class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        ` : ''}
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-white shrink-0">
                            ${item.image ? `<img src="${item.image}" class="object-cover w-full h-full">` : '<div class="w-full h-full flex items-center justify-center text-3xl">☕</div>'}
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-brown uppercase text-sm mb-1">${item.name}</h3>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-2 py-0.5 bg-brown/10 rounded-md text-[10px] font-bold text-brown uppercase">${item.variant}</span>
                                <span class="text-[10px] text-brown/40 font-bold uppercase">Stok: ${item.stocks[item.variant]} Pack</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center border border-brown/10 rounded-lg bg-white overflow-hidden">
                                    <button type="button" onclick="updateQty(${index}, -1)" class="px-3 py-1 hover:bg-brown/5 transition font-bold select-none">-</button>
                                    <span class="w-10 text-center text-xs font-bold">${item.quantity}</span>
                                    <button type="button" onclick="updateQty(${index}, 1)" class="px-3 py-1 hover:bg-brown/5 transition font-bold select-none">+</button>
                                </div>
                                <span class="font-black text-brown text-sm">${formatRupiah(itemSubtotal)}</span>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', row);

                // Hidden Inputs for Form
                hiddenContainer.innerHTML += `
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][variant]" value="${item.variant}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                `;

                // Summary items
                summaryContainer.innerHTML += `
                    <div class="flex justify-between items-center opacity-60">
                        <span>${item.name} (${item.variant}) x ${item.quantity}</span>
                        <span>${formatRupiah(itemSubtotal)}</span>
                    </div>
                `;
            });

            const discount = isMember ? (subtotal * discountRate) : 0;
            const total = subtotal - discount;

            if (document.getElementById('discountAmount')) {
                document.getElementById('discountAmount').innerText = formatRupiah(discount);
            }
            document.getElementById('totalPrice').innerText = formatRupiah(total);
        }

        render();
    </script>
</body>
</html>
