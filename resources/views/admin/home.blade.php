@extends("admin.layouts.master")
@section("title", "Home")

@section("content")
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">کد ها</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">{{ $codes_count }}</div>
                                </div>
                            </div>
                            <div id="chart-revenue-bg" class="chart-sm"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">ورود ها</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">{{ $tokens_count }}</div>
                                </div>
                            </div>
                            <div id="chart-revenue-bg2" class="chart-sm"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">کاربر ها</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">{{ $users_count }}</div>
                                </div>
                            </div>
                            <div id="chart-revenue-bg3" class="chart-sm"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">بازدید از کد ها</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">{{ $codes_visits_count }}</div>
                                </div>
                            </div>
                            <div id="chart-revenue-bg4" class="chart-sm"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row row-cards">
                            <h2 class="mt-3 mb-0">فضای ذخیره سازی:</h2>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="mb-3">{{ round($total_space - $free_space) }} گیگابایت استفاده شده از {{ round($total_space) }} گیگابایت</p>
                                        <div class="progress progress-separated mb-3">
                                            <div class="progress-bar" role="progressbar" style="background-color: #ff5c00;width: {!! ((($total_space - $free_space) * 100) / $total_space) - $this_project / 1000 !!}%"></div>
                                            <div class="progress-bar" role="progressbar" style="background-color: #ffb48e;width: {!! ($this_project / 1000) !!}%"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto d-flex align-items-center pe-2">
                                                <span class="legend me-2" style="background-color: #ff5c00;"></span>
                                                <span>فضا اشغال شده</span>
                                            </div>
                                            <div class="col-auto d-flex align-items-center px-2">
                                                <span class="legend me-2" style="background-color: #ffb48e"></span>
                                                <span>فضای اشغال شده توسط این پروژه</span>
                                            </div>
                                            <div class="col-auto d-flex align-items-center ps-2">
                                                <span class="legend me-2"></span>
                                                <span>فضا آزاد</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="mt-3 mb-0">اخرین بازدید از کد ها:</h2>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                        <div class="divide-y">
                                            @foreach($last_codes as $last_code)
                                                <div>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <span class="avatar" style="background-image: url({{ asset("./assets/images/admin.png") }})"></span>
                                                        </div>
                                                        <div class="col">
                                                            <div class="text-truncate">
                                                                <strong>{{ \App\Models\User::find(\App\Models\Code::find($last_code["id"])["user_id"])["name"] }}</strong> یک کد جدید ایجاد کرد.
                                                            </div>
                                                            <div class="text-secondary">{{ $last_code["created_at"] }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script>
        let fullData1 = @json($codes_history);
        let data1 = []
        let date1 = []
        fullData1.forEach((item) => {
            data1.push(item.count)
            date1.push(item.date)
        })
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "تعداد",
                    data: data1
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: date1,
                colors: ["#FF5C00"],
                legend: {
                    show: false,
                },
            })).render();
        });

        let fullData2 = @json($tokens_history);
        let data2 = []
        let date2 = []
        fullData2.forEach((item) => {
            data2.push(item.count)
            date2.push(item.date)
        })
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg2'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "تعداد",
                    data: data2
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: date2,
                colors: ["#FF5C00"],
                legend: {
                    show: false,
                },
            })).render();
        });

        let fullData3 = @json($users_history);
        let data3 = []
        let date3 = []
        fullData3.forEach((item) => {
            data3.push(item.count)
            date3.push(item.date)
        })
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg3'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "تعداد",
                    data: data3
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: date3,
                colors: ["#FF5C00"],
                legend: {
                    show: false,
                },
            })).render();
        });

        let fullData4 = @json($codes_visits_history);
        let data4 = []
        let date4 = []
        fullData4.forEach((item) => {
            data4.push(item.count)
            date4.push(item.date)
        })
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg4'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "تعداد",
                    data: data4
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: date4,
                colors: ["#FF5C00"],
                legend: {
                    show: false,
                },
            })).render();
        });
    </script>
@endsection