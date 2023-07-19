@extends('layout.layout')

@section('page_title', 'Корзина - ' . config('app.name'))

@section('main_content')
    <div class="container">

        @if(isset($products))
            <h2 class="mb-0">Корзина</h2>

            <div class="d-flex justify-content-end mb-3">
                <span class="d-block blue_link" onclick="clearCart()">Очистить корзину</span>
            </div>

            <div class="border-bottom"></div>

            @foreach($products as $product)
            <x-cart-item :product="$product" :index="$loop->index" />
            @endforeach

            <div class="cart_block mb-2">
                <div class="cart_descr"></div>
                <livewire:cart-total :cost="$cart_cost" />
            </div>


            <form method="POST" class="cart_details_cont" action="{{ route('orders.create') }}" onsubmit="return validateOrderForm()" novalidate>
                @csrf
                <label for="nameInput" class="form-label required">Имя:</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @else mb-4 @enderror" id="nameInput" value="{{ old('name') ?? ($user ? $user->name : '') }}" onblur="validateName(this)">
                @error('name')
                <div id="nameInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
                @enderror

                <label for="phoneInput" class="form-label required">Номер телефона:</label>
                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @else mb-4 @enderror" id="phoneInput" value="{{ old('phone') ?? ($user ? $user->phone : '') }}" onblur="validatePhone(this)">
                @error('phone')
                <div id="phoneInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
                @enderror

                <label for="emailInput" class="form-label">Адрес email:</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @else mb-4 @enderror" id="emailInput" value="{{ old('email') ?? ($user ? $user->email : '') }}">
                @error('email')
                <div id="emailInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
                @enderror


                {{-- --------------- Tabs ------------------ --}}

                <ul class="nav nav-tabs mb-4 mt-5" id="delivery_tab_cont">
                    <li class="nav-item">
                        <div class="nav-link active" data-pageid="delivery">Доставка</div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link blue_link" data-pageid="self-delivery">Самовывоз</div>
                    </li>
                </ul>

                <div class="mb-45" id="delivery_cont">
                    <label for="delAddrInput" class="form-label required">Адрес доставки:</label>
                    <input type="text" name="delivery_address" class="form-control @error('delivery_address') is-invalid @else mb-4 @enderror" id="delAddrInput" value="{{ old('delivery_address') ?? ($user ? $user->address : '') }}" onblur="validateShippingAddress(this)">
                    @error('delivery_address')
                    <div id="delAddrInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-45" id="self-delivery_cont" style="display: none">
                    <span class="d-block mb-2">Выберите магазин:</span>
                    <select class="form-select mb-4" name="shop_id" aria-label="Выбор магазина">
                    @foreach($shops as $shop)
                        @if($loop->first)
                        <option value="{{ $shop->id }}" selected>{{ $shop->address }}</option>
                        @else
                        <option value="{{ $shop->id }}">{{ $shop->address }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>


                {{-- --------------- Payment methods ------------------ --}}

                <span class="d-block mb-2">Способ оплаты:</span>
                <div class="mb-45" id="pay_method_cont">
                    <div class="form-check" id="pay_method_online_cont">
                        <input class="form-check-input" type="radio" name="payment_method" value="online" id="pay_method_online" checked>
                        <label class="form-check-label" for="pay_method_online">
                            Картой онлайн
                        </label>
                    </div>
                    <div class="form-check" id="pay_method_card_cont">
                        <input class="form-check-input" type="radio" name="payment_method" value="card" id="pay_method_card">
                        <label class="form-check-label" for="pay_method_card">
                            Картой курьеру
                        </label>
                    </div>
                    <div class="form-check" id="pay_method_cash_cont">
                        <input class="form-check-input" type="radio" name="payment_method" value="cash" id="pay_method_cash">
                        <label class="form-check-label" for="pay_method_cash">
                            Наличными курьеру
                        </label>
                    </div>
                    <div class="form-check" id="pay_method_shop_cont" style="display: none">
                        <input class="form-check-input" type="radio" name="payment_method" value="shop" id="pay_method_shop">
                        <label class="form-check-label" for="pay_method_shop">
                            Картой или наличными в магазине
                        </label>
                    </div>
                </div>


                <input type="hidden" name="delivery_type" value="delivery" id="delivery_type">

                <button type="submit" class="btn2 btn2-primary cart_order_btn">Оформить заказ</button>
            </form>

            @push('scripts')
                <script src="{{ asset('js/cart.js') }}"></script>
            @endpush

        @else

            <div class="text-center fw-light fs-2 lightgrey_text" style="padding: 120px 0">
                В корзине пусто
            </div>

            @if($recently_viewed->count())
                <x-carousel title="Недавно просмотренные" section="crs_recently_viewed">
                    @foreach($recently_viewed as $item)
                        <x-product-card type="carousel" :product="$item" />
                    @endforeach
                </x-carousel>
                <script>let carousel_perpage = 5;</script>

                @push('css')
                    <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
                @endpush

                @push('scripts')
                    <script src="{{ asset('js/splide.min.js') }}"></script>
                    <script src="{{ asset('js/recently_viewed.js') }}"></script>
                @endpush
            @endif
        @endif

    </div>
@endsection
