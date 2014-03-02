// JavaScript Document

$(function () {
                var chart;
                $(document).ready(function() {
                    colors: ['#0000A0', '#800000', '#FF8040' ,'#C33', '#008000', '#000', '#8000FF', '#808080', '#80FFFF', '#CFF'],
                    Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function(color) {
                        return {
                            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
                            stops: [
                                [0, color],
                                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]
                            ]
                        };
                    });
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            margin: [10, 10, 10, 10]
                        },
                        exporting: {enabled: false},
                        title: {
                            text: '',
                            enabled: false
                        },
                        credits: {
                            enabled: false,
                            text: '',
                            href: 'http://forumhulp.com'
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage, 1) +' %';
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#000000',
                                    connectorColor: '#000000',
									distance: 3,
                                    formatter: function() {
                                        return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage, 1) +' %';
                                    }
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Browser share',
                            data: dataserie
                        }]
                    });
                });
                
            });
