@php
    $header = headerData();
    $sidebar = sidebar();
    $footer = footerData();
    $socialIcons = socialIcons();
    $productMenu = productMenu();

    $currentPath = trim(request()->path(), '/');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JINDAL LIFESTYLE</title>

    <link href="{{ asset('frontend-assets/css/style.css') }}" rel="stylesheet">
    @if (request()->is('contact-us') === false)
        <link href="{{ asset('frontend-assets/css/infra.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/banner.css') }}" rel="stylesheet">
    @endif
    @if(request()->is('/') || request()->is('home'))
        <link href="{{ asset('frontend-assets/css/home.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('frontend-assets/css/about.css') }}" rel="stylesheet">
    @endif

</head>

<body>
    <div class="menu-overlay"></div>
    <div class="header_group {{ !request()->is('/') ? 'inner_header_group' : '' }}">
        <header class="site-header">
            <div class="home_logo">
                @if (request()->is('/'))
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('frontend-assets/images/logo.webp') }}" class="img-fluid w-100" alt="Jindal Lifestyle">
                    </a>
                @else
                    <a href="{{ url('/') }}">
                            <img src="{{ asset('frontend-assets/images/jindal_logo1.webp') }}" class="img-fluid w-100" alt="Jindal Lifestyle">
                    </a>
                @endif
            </div>
            <div class="main_menu">
                <nav>
                    <ul>
                        @foreach ($header as $menu)
                            @php
                                $menuSlug = trim($menu['slug'] ?? '', '/');
                                $isActive = $currentPath === $menuSlug
                                    || ($menuSlug !== '' && Str::startsWith($currentPath, $menuSlug . '/'));
                                $isMega = $menuSlug === 'our-businesses';
                                $hasChildren = !empty($menu['children']) && $menu['children']->count() > 0;
                            @endphp

                            <li class="{{ $isMega ? 'mega-parent' : ($hasChildren ? 'about-parent' : '') }} {{ $isActive ? 'active' : '' }}">
                                <a href="{{ $isMega ? '#' : url($menu['slug'] ?? '') }}"
                                    @if ($menu['target_blank'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                                    @if ($isActive) aria-current="page" @endif>
                                    {{ strtoupper($menu['title'] ?? 'UNTITLED') }}
                                </a>

                                @if ($hasChildren && !$isMega)
                                    <div class="about-dropdown">
                                        @foreach ($menu['children'] as $child)
                                            <a href="{{ ($child['slug'] ?? '') }}"
                                                @if ($child['target_blank'] ?? false) target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $child['title'] ?? 'Untitled' }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </header>
        <div class="ham_menu">
            <a href="javascript:void(0)" class="menu_toggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <div class="side_menu">
            <div class="menu_inner">
                @foreach ($sidebar as $menu)
                    @php
                        $slug        = $menu['slug'] ?? '';
                        $title       = $menu['title'] ?? '';
                        $targetBlank = !empty($menu['target_blank']);
                        $children    = $menu['children'] ?? collect();
                    @endphp

                    <div class="menu_block">
                        @if($children->isNotEmpty())
                            <div class="ham_head">{{ $title }}</div>
                            <ul>
                                @foreach ($children as $child)
                                    @php
                                        $childSlug        = $child['slug'] ?? '';
                                        $childTitle       = $child['title'] ?? '';
                                        $childTargetBlank = !empty($child['target_blank']);
                                    @endphp
                                    <li>
                                        <a href="{{ $childSlug ? url($childSlug) : 'javascript:void(0)' }}"
                                            @if($childTargetBlank) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $childTitle }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="ham_head">
                                <a href="{{ $slug ? url($slug) : 'javascript:void(0)' }}"
                                    @if($targetBlank) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $title }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="menu_overlay"></div>
    <section class="mega-menu">
        <div class="container">
            <div class="mega-title">
                Solutions Across Industries &amp; Lifestyles.
            </div>
            <div class="mega-grid">
                @foreach ($productMenu as $item)
                    <a href="{{ url($item['link']) }}" class="mega-item">
                        @if (!empty($item['image']))
                            <figure>
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                            </figure>
                        @else
                            <figure class="placeholder"></figure>
                        @endif
                        <span>{{ $item['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>