<?php

namespace Ophim\ThemeBcco;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemeBccoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/bcco')
        ], 'bcco-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'bcco' => [
                'name' => 'Theme Bcco',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-bcco',
                'publishes' => ['bcco-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommendations Limit',
                        'type' => 'number',
                        'hint' => 'Number',
                        'value' => 10,
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                        'value' => "Phim bộ mới||type|series|12|/danh-sach/phim-bo\r\nPhim lẻ mới||type|single|12|/danh-sach/phim-bo\r\nPhim lẻ mới||type|single|12|/danh-sach/phim-bo\r\nPhim lẻ mới||type|single|12|/danh-sach/phim-bo",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => "Top phim lẻ||type|single|view_total|desc|9\r\nTop phim bộ||type|series|view_total|desc|9",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <footer class="footer1 bg-dark">
                            <div class="footer-widget-area ptb100">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="widget widget-about">
                                                <div class="logo2"><img width="128" height="33"
                                                                        alt="OPHIMCMS | Xem Phim Thuyết Minh VietSub"
                                                                        src="/themes/bcco/images/logo.png"/></div>
                                                <p class="nomargin">Tổng hợp phim mới, phim HOT vietsub, thuyết minh nhanh nhất. Xem phim
                                                    nhanh online miễn phí, chất lượng full HD.</p></div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="widget widget-links"><h4 class="widget-title">Phim Mới</h4>
                                                <ul class="general-listing">
                                                    <li><a href="phim-le.html">Phim lẻ mới</a></li>
                                                    <li><a href="phim-bo.html">Phim bộ mới</a></li>
                                                    <li><a href="sap-chieu.html">Phim sắp chiếu</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="widget widget-links"><h4 class="widget-title">Phim Lẻ</h4>
                                                <ul class="general-listing">
                                                    <li><a href="the-loai/hanh-dong.html">Phim hành động</a></li>
                                                    <li><a href="the-loai/co-trang.html">Phim kiếm hiệp-cổ trang</a></li>
                                                    <li><a href="the-loai/vien-tuong.html">Phim viễn tưởng</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="widget widget-links"><h4 class="widget-title">Tổng hợp phim hay</h4>
                                                <ul class="general-listing">
                                                    <li><a href="quoc-gia/han-quoc.html">Phim Hàn Quốc</a></li>
                                                    <li><a href="quoc-gia/trung-quoc.html">Phim Trung Quốc</a></li>
                                                    <li><a href="quoc-gia/thai-lan.html">Phim Thái Lan</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <ul class="general-listing">
                                            <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <ul class="general-listing">
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <ul class="general-listing">
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <ul class="general-listing">
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                                <li><a target="_blank" rel="nofollow" href="/">TextLink</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-copyright-area ptb30">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-center">
                                                <div class="copyright">All Rights Reserved by <a href="#">OPHIMCMS</a>.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
