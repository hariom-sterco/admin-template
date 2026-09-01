@include('includes.header')

<section class="inner_banner">
    <figure class="banner_img">
        <img src="https://project-demo.in/jindal/assets/img/pages/4/section_1787124292_6a855a446fc39.jpg"
            alt="Overview Banner" class="img-fluid">
    </figure>
    <div class="container-sm">
        <div class="banner_content">
            <span class="sub_title">{{ $page->title }}</span>

            <h1>Coming Soon</h1>
            <span class="line-banner"></span>
        </div>
    </div>
</section>

<section class="build">
    <div class="container-sm">
        <div class="build_img">
            <figure> <img src="{{ asset('/frontend-assets/images/coming-soon.webp') }}" alt="Coming Soon"
                    class="img-fluid img_radius"></figure>
        </div>
    </div>
</section>

@include('includes.footer')
