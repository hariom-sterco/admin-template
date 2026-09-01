@php
    $footer = footerData();
    $quickLinks = quickLinks();
    $socialIcons = socialIcons();
    $productMenu = productMenu();
    $header = headerData();
    $sidebar = sidebar();
@endphp

<footer class="footer">
    <div class="container-sm">
        <div class="footer-grid">
            <div class="footer-left">
                <img src="{{ asset('frontend-assets/images/logo.webp') }}" alt="Jindal Lifestyle" class="footer-logo">
                <ul class="footer-contact">
                    <li>
                        <div class="icon-footer">
                            <img src="{{ asset('frontend-assets/images/svg-icons/location-icon.svg') }}" alt="Location">
                        </div>
                        <span>{{ supportInfo('address') }}</span>
                    </li>
                    <li>
                        <div class="icon-footer">
                            <img src="{{ asset('frontend-assets/images/svg-icons/phone-icon.svg') }}" alt="Phone">
                        </div>

                        <a href="tel:{{ supportInfo('phone') }}">
                            {{ supportInfo('phone') }}
                        </a>
                    </li>
                    <li>
                        <div class="icon-footer">
                            <img src="{{ asset('frontend-assets/images/svg-icons/mail-icon.svg') }}" alt="Email">
                        </div>
                        <a href="mailto:{{ supportInfo('email') }}">
                            {{ supportInfo('email') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="footer-right">
                <div class="footer-menu-top">
                    <span>Our Businesses</span>
                    <div class="line"></div>
                    <div class="footer_links1">
                        @foreach($quickLinks as $menu)
                            <a href="{{ url($menu['slug']) }}" @if(($menu['target_blank'] ?? false)) target="_blank"
                            rel="noopener noreferrer" @endif>{{ $menu['title'] }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="footer-links">
                    @foreach($footer as $menu)
                        <a href="{{ url($menu['slug']) }}" @if(($menu['target_blank'] ?? false)) target="_blank"
                        rel="noopener noreferrer" @endif>{{ $menu['title'] }}</a>
                    @endforeach
                </div>

                <div class="footer-bottom">
                    <div class="social">
                        @foreach($socialIcons as $social)
                            <a href="{{ $social['value'] }}" target="_blank">
                                <img src="{{ $social['image'] }}" alt="{{ ucfirst($social['key']) }}" class="img-fluid">
                            </a>
                        @endforeach
                    </div>

                    <div class="copyright">
                        <span>
                            Copyright © 2026
                        </span>
                        <span>
                            Website Design and Development by
                            <a href="https://www.stercodigitex.com/" target="_blank" rel="noopener noreferrer">
                                Sterco
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="mobile_fixed-menu for_mobile">
    <div class="bottom-nav">
        <button class="biz-item" data-target="panel-businesses">
            <span class="biz_icon"><img src="{{ asset('frontend-assets/images/svg-icons/business_icon.svg') }}" class="img_business">
                <img src="{{ asset('frontend-assets/images/svg-icons/business_icon_active.svg') }}" class="img_active">
            </span>
            <span class="biz_label">Businesses</span>
        </button>
        <button class="biz-item" data-target="panel-contact">
            <span class="biz_icon"><img src="{{ asset('frontend-assets/images/svg-icons/phone-icon1.svg') }}" class="img_business"><img
                    src="{{ asset('frontend-assets/images/svg-icons/phone-icon1-active.svg') }}" class="img_active"></span>
            <span class="biz_label">Contact</span>
        </button>
        <button class="biz-item" data-target="panel-menu">
            <span class="biz_icon"><img src="{{ asset('frontend-assets/images/svg-icons/menu_icon.svg') }}" class="img_business"><img
                    src="{{ asset('frontend-assets/images/svg-icons/menu_icon_active.svg') }}" class="img_active"></span>
            <span class="biz_label">Menu</span>
        </button>
    </div>

    <div class="panel-container">
        <div id="panel-businesses" class="biz-tab-panel">
            <div class="panel-content">
                <div class="biz-grid">
                    @foreach ($productMenu as $item)
                        <a href="{{ url($item['link']) }}" class="biz-card">
                            <div class="biz-thumb">
                                <img src="{{ $item['image'] ?? asset('images/m-business_pic1.webp') }}"
                                    alt="{{ $item['name'] }}">
                            </div>
                            <span class="biz-title">{{ $item['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="panel-contact" class="biz-tab-panel">
            <div class="panel-content">
                <div class="contact-panel">
                    <div class="brand-header">
                        <img src="{{ asset('frontend-assets/images/contact-logo.webp') }}" class="img-fluid">
                    </div>
                    <div class="contact-info">
                        <div class="info-row">
                            <span class="info-icon">
                                <img src="{{ asset('frontend-assets/images/svg-icons/phone-icon.svg') }}">
                            </span>
                            <a href="tel:{{ supportInfo('phone') }}" class="info-text">
                                {{ supportInfo('phone') }}
                            </a>
                        </div>

                        <div class="info-row">
                            <span class="info-icon">
                                <img src="{{ asset('frontend-assets/images/svg-icons/mail-icon.svg') }}">
                            </span>
                            <a href="mailto:{{ supportInfo('email') }}" class="info-text">
                                {{ supportInfo('email') }}
                            </a>
                        </div>

                        <div class="info-row">
                            <span class="info-icon">
                                <img src="{{ asset('frontend-assets/images/svg-icons/map-icon.svg') }}">
                            </span>
                            <span class="info-text">
                                {{ supportInfo('address') }}
                            </span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="button" class="btn-outline">Plants</button>
                        <button type="button" class="btn-outline">Stores</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="panel-menu" class="biz-tab-panel">
            <div class="panel-content">
                <div class="menu-panel">
                    <div class="menu-dark">
                        <ul class="menu-list">
                            @foreach ($header as $menu)
                                @php
                                    $slug        = $menu['slug'] ?? '';
                                    $title       = $menu['title'] ?? '';
                                    $targetBlank = !empty($menu['target_blank']);
                                    $children    = $menu['children'] ?? collect();
                                @endphp

                                <li class="menu-item">
                                    @if ($children->isNotEmpty())
                                        <a href="javascript:void(0)">
                                            {{ $title }}
                                            <span class="menu-icon">+</span>
                                        </a>
                                        <ul>
                                            @foreach ($children as $child)
                                                @php
                                                    $childSlug        = $child['slug'] ?? '';
                                                    $childTitle       = $child['title'] ?? '';
                                                    $childTargetBlank = !empty($child['target_blank']);
                                                @endphp
                                                <li>
                                                    <a href="{{$childSlug}}"
                                                        @if($childTargetBlank) target="_blank" rel="noopener noreferrer" @endif>
                                                        {{ $childTitle }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <a href="{{ $slug ? url($slug) : 'javascript:void(0)' }}"
                                            @if($targetBlank) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $title }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="menu-light">
                        <ul class="menu-list">
                            @foreach ($sidebar as $menu)
                                @php
                                    $slug        = $menu['slug'] ?? '';
                                    $title       = $menu['title'] ?? '';
                                    $targetBlank = !empty($menu['target_blank']);
                                    $children    = $menu['children'] ?? collect();
                                @endphp

                                <li class="menu-item">
                                    @if ($children->isNotEmpty())
                                        <a href="javascript:void(0)">
                                            {{ $title }}
                                            <span class="menu-icon">+</span>
                                        </a>
                                        <ul>
                                            @foreach ($children as $child)
                                                @php
                                                    $childSlug        = $child['slug'] ?? '';
                                                    $childTitle       = $child['title'] ?? '';
                                                    $childTargetBlank = !empty($child['target_blank']);
                                                @endphp
                                                <li>
                                                    <a href="{{$childSlug}}"
                                                        @if($childTargetBlank) target="_blank" rel="noopener noreferrer" @endif>
                                                        {{ $childTitle }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <a href="{{ $slug ? url($slug) : 'javascript:void(0)' }}"
                                            @if($targetBlank) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $title }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('frontend-assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('frontend-assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend-assets/js/swiper-bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="{{ asset('frontend-assets/js/SmoothScroll.min.js') }}"></script>
<script src="{{ asset('frontend-assets/js/gsap.min.js') }}"></script>
<script src="{{ asset('frontend-assets/js/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('frontend-assets/js/home.js') }}"></script>
@if(request()->is('/') || request()->is('home'))
    <script src="{{ asset('frontend-assets/js/banner.js') }}"></script>
@else
    <script src="{{ asset('frontend-assets/js/inner.js') }}"></script>
@endif

</body>

</html>