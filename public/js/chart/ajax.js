let body = $('body'),
    hasBeenAlreadyOpen = false,
    accountId = window.location.pathname.split('/')[2];

body.on('click', '#chart-tab', function(){
    if(!hasBeenAlreadyOpen){
        $.ajax({
            url: '/transaction/load-all-transactions-categories-by-account',
            data: {account_id: accountId},
            type: 'GET',
            success: function(data) {
                loadChart(data);
            },
            complete: function() {
                let spinnerContainer = $('#spinner-container');
                if(spinnerContainer.length > 0) {
                    spinnerContainer.remove();
                }
                hasBeenAlreadyOpen = true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('jqXHR', jqXHR);
                console.log('textStatus', textStatus);
                console.log('errorThrown', errorThrown);
            }
        });
    }
});

function loadChart(data) {
    if(typeof data === 'object' && data.length > 0){
        Highcharts.chart('chart-container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Amount<br>by<br>category',
                align: 'center',
                verticalAlign: 'middle',
                y: -10
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y:.1f}€ ({point.percentage:.1f}%)</b>'
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    center: ['50%', '50%'],
                }
            },
            series: [{
                type: 'pie',
                name: 'Category share',
                innerSize: '50%',
                data: data
            }]
        });
    } else {
        let chartContainer = $('#chart-container');
        if(chartContainer.length > 0){
            chartContainer.append('<div class="alert alert-warning" role="alert">No transactions yet for this account</div>');
        }
    }
}