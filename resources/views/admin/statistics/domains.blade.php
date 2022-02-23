
@extends('layouts/contentLayoutMaster')

@section('title', 'Domains')

@section('vendor-style')
        {{-- Vendor Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
@endsection

@section('content')


  <!-- Complex headers table -->
  <section id="headers">
      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Filters</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="users-list-filter">
                    <form action="/admin/statistics/domains">
                      <input type="hidden" name="filter" value="yes">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="text-bold-600"> Date Range </label>
                                        <select class="form-control" name="date_range" id="filter_date_range">
                                            <option value="Period"> Period </option>
                                            <option value="Today"> Today </option>
                                            <option value="Last 7 Days"> Last 7 Days </option>
                                            <option value="Last 30 Days"> Last 30 Days </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <label class="text-bold-600">Period (From)</label>
                                        <input type='text' value="{{ ($filter->has('period_from'))?$filter->get('period_from'):date('d F, Y') }}" id="period_from" name="period_from" class="form-control pickadate" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <label class="text-bold-600">Period (To)</label>
                                        <input type='text' value="{{ ($filter->has('period_to'))?$filter->get('period_to'):date('d F, Y') }}" id="period_to" name="period_to" class="form-control pickadate" />

                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label class="text-bold-600">Campaign</label>

                                          <select class="select2 form-control" name="campaign_id" id="users-list-role">
                                            <option value="All"> All </option>
                                            @foreach($campaigns as $campaign)
                                                <option {{ ($filter->get('campaign_id') == $campaign->id)?"selected":"" }} value="{{ $campaign->id }}"> {{ $campaign->campaign_name }}</option>
                                            @endforeach
                                          </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">

                                <div class="row">
                                    <div class="col-12">
                                        <label class="text-bold-600">Source</label>
                                        <select class="form-control" id="utm_source" name="utm_source">
                                            <option value="All"> All </option>
                                            @foreach($utm_sources as $utm_source)
                                                <option {{ ($filter->get('utm_source') == $utm_source->utm_source)?"selected":"" }} value="{{ $utm_source->utm_source }}">{{ $utm_source->utm_source }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label class="text-bold-600">Medium</label>
                                        <select class="form-control" id="utm_medium" name="utm_medium">
                                            <option value="All"> All </option>
                                            @foreach($utm_mediums as $utm_medium)
                                                <option {{ ($filter->get('utm_medium') == $utm_medium->utm_medium)?"selected":"" }} value="{{ $utm_medium->utm_medium }}">{{ $utm_medium->utm_medium }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label class="text-bold-600">Content</label>
                                        <select class="form-control" id="utm_content" name="utm_content">
                                            <option value="All"> All </option>
                                            @foreach($utm_contents as $utm_content)
                                                <option {{ ($filter->get('utm_content') == $utm_content->utm_content)?"selected":"" }} value="{{ $utm_content->utm_content }}">{{ $utm_content->utm_content }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <input type="submit" class="pl-2 pr-2 btn btn-primary float-right" value="Filter">
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
                  <div class="card-header">
                      <h1 class="text-bold-600">Domains: {{($filter->has('campaign_id') && $filter->get('campaign_id') != "All")?$selcampaign->campaign_name:"All" }} - {{ ($filter->has('period_from') && $filter->has('period_to'))?$filter->get('period_from') . " - " .$filter->get('period_to'). " Statistics Per Domains":"Today's Statistics Per Domain" }}</h1>

                  </div>
                <div class="card-body card-dashboard">

                  <ul class="nav nav-pills">
                      <li class="nav-item">
                        <a class="nav-link active" id="table-tab" data-toggle="pill" href="#table" aria-expanded="true">Statistics Table</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="charts-tab" data-toggle="pill" href="#charts"
                          aria-expanded="false">Statistics Charts</a>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane  active" id="table" aria-labelledby="table-tab" aria-expanded="true">
                          <div class="table-responsive">
                              <table id="click-events" class="table table-striped table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Domain</th>
                                        <th># of Unique Clicks</th>
                                        <th># of Non-Unique Clicks</th>
                                        <th>Postbacks</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($statistics as $statistic)
                                    @php
                                    $disallowed = array('http://', 'https://', 'https://www.', 'www.');
                                    foreach($disallowed as $d) {
                                        if(strpos($statistic->click_source_site_domain, $d) === 0) {
                                            $newdomain = str_replace($d, '', $statistic->click_source_site_domain);
                                        }
                                    }
                                    @endphp
                                        <tr style="cursor:pointer" href="{{ url('admin/statistics/domains/site?name='.$statistic->click_source_site_domain) }}">
                                            <td> {{ ($newdomain)?$newdomain:"[No Site Name or Direct Access]"}} </td>
                                            <td> {{ $statistic->unique_clicks + $statistic->click_count }} </td>
                                            <td> {{ $statistic->non_unique_clicks - $statistic->click_count  }} </td>
                                            <td> {{ $statistic->conversions }} </td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                        <th>Domain</th>
                                        <th># of Unique Clicks</th>
                                        <th># of Non-Unique Clicks</th>
                                        <th>Postbacks</th>

                                    </tr>
                                </tfoot>
                              </table>
                          </div>
                      </div>
                      <div class="tab-pane" id="charts" role="tabpanel" aria-labelledby="charts-tab" aria-expanded="false">
                          <div class="row match-height">
                              <!-- Pie Chart -->
                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="card bg-light">
                                    <div class="card-header">
                                      <h4 class="card-title text-white">Device</h4>
                                    </div>
                                    <div class="card-content">
                                      <div class="card-body">
                                        <div id="device-chart" class="mx-auto"></div>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-12 col-lg-4 col-md-4">
                                <div class="card bg-light">
                                  <div class="card-header">
                                    <h4 class="card-title text-white">Browser</h4>
                                  </div>
                                  <div class="card-content">
                                    <div class="card-body">
                                      <div id="browser-chart" class="mx-auto"></div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="card bg-light">
                                    <div class="card-header">
                                      <h4 class="card-title text-white">OS</h4>
                                    </div>
                                    <div class="card-content">
                                      <div class="card-body">
                                        <div id="city-chart" class="mx-auto"></div>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row match-height">
                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="card bg-light">
                                    <div class="card-header">
                                      <h4 class="card-title text-white">City</h4>
                                    </div>
                                    <div class="card-content">
                                      <div class="card-body">
                                        <div id="domain-chart" class="mx-auto"></div>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="card bg-light">
                                    <div class="card-header">
                                      <h4 class="card-title text-white">Url</h4>
                                    </div>
                                    <div class="card-content">
                                      <div class="card-body">
                                        <div id="url-chart" class="mx-auto"></div>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="card bg-light">
                                    <div class="card-header">
                                      <h4 class="card-title text-white">Medium</h4>
                                    </div>
                                    <div class="card-content">
                                      <div class="card-body">
                                        <div id="medium-chart" class="mx-auto"></div>
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
        </div>
          </div>
      </div>
  </section>
  <!--/ Complex headers table -->

  <!--/ Scroll - horizontal and vertical table -->
@endsection
@section('vendor-script')
{{-- Vendor js files --}}
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/charts/chart-apex.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/webix-list/statistics-page.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
        <script>
            $(document).ready(function() {
                $("#filter_date_range").change(function(){
                    var date_range = $(this).val();
                    var today = "{{ date('j F, Y') }}";
                    var last_7 = "{{ date('j F, Y', strtotime('-7 days')) }}";
                    var last_30 = "{{ date('j F, Y', strtotime('-30 days')) }}";

                    switch (date_range){
                        case 'Today':
                            $('#period_from').val(today);
                            $('#period_to').val(today);

                        break;
                        case 'Last 7 Days':
                            $('#period_from').val(last_7);
                            $('#period_to').val(today);
                        break;
                        case 'Last 30 Days':
                            $('#period_from').val(last_30);
                            $('#period_to').val(today);
                        break;
                    }
                });

                $('#click-events').DataTable( {
                    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
                    "order": []
                });

                $('#period_from').pickadate();
                $('#period_to').pickadate();
                $('.pickadate').on('change', function () {
                    if ($(this).attr('id') === 'period_from') {
                        $('#period_to').pickadate('picker').set('min',$(this).val());
                    }
                    if ($(this).attr('id') === 'period_to') {
                        $('#period_from').pickadate('picker').set('max',$(this).val());
                    }
                });
                $('#click-events').on( 'click', 'tbody tr', function () {
                    window.open(
                      $(this).attr('href'),
                      '_blank' // <- This is what makes it open in a new window.
                    );
                } );

                var $primary = '#7367F0',
                    $success = '#28C76F',
                    $danger = '#EA5455',
                    $warning = '#FF9F43',
                    $info = '#00cfe8',
                    $label_color_light = '#dae1e7';

                var themeColors = [$primary, $success, $danger, $warning, $info];
                var browser_label = [
                @foreach ($browsers['chart_label'] as $chart_label)
                     "{{ $chart_label }}" ,
                @endforeach
                ];

                var browser_count = [
                @foreach ($browsers['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];
                var browserChartOptions = {
                    chart: {
                    type: 'donut',
                    height: 350
                    },
                    colors: themeColors,
                    labels: browser_label,
                    series: browser_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }
                var device_label = [
                @foreach ($devices['chart_label'] as $chart_label)
                     "{{ $chart_label }}" ,
                @endforeach
                ];

                var device_count = [
                @foreach ($devices['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var deviceChartOptions = {
                    chart: {
                    type: 'donut',
                    height: 350
                    },
                    colors: themeColors,
                    labels: device_label,
                    series: device_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var city_label = [
                @foreach ($cities['chart_label'] as $chart_label)
                     "{{ $chart_label }}" ,
                @endforeach
                ];

                var city_count = [
                @foreach ($cities['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var cityChartOptions = {
                    chart: {
                    type: 'donut',
                    height: 350
                    },
                    colors: themeColors,
                    labels: city_label,
                    series: city_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var domain_label = [
                @foreach ($domains['chart_label'] as $chart_label)
                     "{{ $chart_label }}" ,
                @endforeach
                ];

                var domain_count = [
                @foreach ($domains['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var domainChartOptions = {
                    chart: {
                    type: 'donut',
                    height: 350
                    },
                    colors: themeColors,
                    labels: domain_label,
                    series: domain_count,
                    legend: {
                    position: 'top',
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var url_label = [
                @foreach ($urls['chart_label'] as $chart_label)
                     "{{ $chart_label }}" ,
                @endforeach
                ];

                var url_count = [
                @foreach ($urls['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var urlChartOptions = {
                    chart: {
                    type: 'donut',
                    height: 350
                    },
                    colors: themeColors,
                    labels: url_label,
                    series: url_count,
                    legend: {
                    position: 'top',
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var medium_label = [
                @foreach ($mediums['chart_label'] as $chart_label)
                     "{{ $chart_label }}" ,
                @endforeach
                ];

                var medium_count = [
                @foreach ($mediums['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var mediumChartOptions = {
                    chart: {
                    type: 'donut',
                    height: 350
                    },
                    colors: themeColors,
                    labels: medium_label,
                    series: medium_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var browserChart = new ApexCharts(
                    document.querySelector("#browser-chart"),
                    browserChartOptions
                );
                var deviceChart = new ApexCharts(
                    document.querySelector("#device-chart"),
                    deviceChartOptions
                );
                var cityChart = new ApexCharts(
                    document.querySelector("#city-chart"),
                    cityChartOptions
                );

                var domainChart = new ApexCharts(
                    document.querySelector("#domain-chart"),
                    domainChartOptions
                );

                var urlChart = new ApexCharts(
                    document.querySelector("#url-chart"),
                    urlChartOptions
                );

                var mediumChart = new ApexCharts(
                    document.querySelector("#medium-chart"),
                    mediumChartOptions
                );

                browserChart.render();
                deviceChart.render();
                cityChart.render();
                domainChart.render();
                urlChart.render();
                mediumChart.render();

            } );
        </script>
@endsection
