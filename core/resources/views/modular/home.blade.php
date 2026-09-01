@include('includes.header')

{!! $cms['home_banner_0'] ?? '' !!}
{!! $cms['home_facts_1'] ?? '' !!}
{!! $cms['home_about_2'] ?? '' !!}
{!! $cms['home_business_3'] ?? '' !!}
{!! $cms['home_leadership_4'] ?? '' !!}
{!! $cms['home_engineering_5'] ?? '' !!}
{!! $cms['home_sustainability_6'] ?? '' !!}

<section class="home_happening">
    <div class="container-sm">
        <h4 class="title24" data-fade="up" data-once="true" data-delay="0.1">Happenings</h4>
        @if(!empty($modular['happenings']))
            @php
                $happenings = collect($modular['happenings'])->values();
                $withImage = $happenings->take(2);
                $withoutImage = $happenings->slice(2);
            @endphp
            <div class="happening_grid">
                @if($withImage->isNotEmpty())
                    <div class="left_happening">
                        @foreach ($withImage as $index => $happening)
                            @php
                                $image = $happening['home_image'] ?: asset('assets/img/placeholder.webp');
                                $slug = $happening['slug'] ?? '';
                                $title = $happening['title'] ?? '';
                                $date = !empty($happening['date']) ? \Carbon\Carbon::parse($happening['date']) : null;
                            @endphp
                            <div class="home_happening_box" data-fade="up" data-once="true" data-delay="0.2">
                                <div class="happening_img">
                                    <img src="{{ $image }}" class="img-fluid w-100" alt="{{ $title }}">
                                </div>
                                <div class="home_happening_detail">
                                    @if($date)
                                        <div class="date">
                                            <h5>{{ $date->format('d') }}</h5><span>{{ $date->format('M') }}</span>
                                        </div>
                                    @endif
                                    <h6>{{ $title }}</h6>
                                </div>
                                <a href="{{ url('news-events/' . $slug) }}" class="streched_link"></a>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if($withoutImage->isNotEmpty())
                    <div class="right_happening">
                        @foreach ($withoutImage as $index => $happening)
                            @php
                                $slug = $happening['slug'] ?? '';
                                $title = $happening['title'] ?? '';
                                $date = !empty($happening['date']) ? \Carbon\Carbon::parse($happening['date']) : null;
                            @endphp
                            <div class="home_happening_box" data-fade="up" data-once="true" data-delay="0.2">
                                <div class="home_happening_detail">
                                    @if($date)
                                        <div class="date">
                                            <h5>{{ $date->format('d') }}</h5><span>{{ $date->format('M') }}</span>
                                        </div>
                                    @endif
                                    <h6>{{ $title }}</h6>
                                </div>
                                <a href="{{ url('news-events/' . $slug) }}" class="streched_link"></a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
        <div class="mas_icon2"><img src="{{ asset('frontend-assets/images/svg-icons/mask_icon2.svg') }}"
                class="img-fluid" alt=""></div>
    </div>
</section>

{!! $cms['home_social_wall_7'] ?? '' !!}

@include('includes.footer')