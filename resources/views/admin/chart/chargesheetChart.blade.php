<div class="col-lg-6 col-xs-6">

    <div id='myChargesheetChart' style='background: white;'>
        <div id="yearclass">
            <div style="text-align: center; font-size:20px;"><b>Chargesheet Chart</b></div>
            <label>Select year:</label>
            <select name="yearChargesheetName" id="yearChargesheet">
                @foreach($quryYearChargesheet as $quryYearChargesheet)
                    <option value="{{ $quryYearChargesheet->year }}"> {{ $quryYearChargesheet->year }} </option>
                @endforeach
            </select>
        </div>

    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>



        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            makeChargesheetChart(<?=json_encode($dataChargesheet)?>);

            $('#yearChargesheet').on('change', function (e) {
                var yearChargesheet = $('select[name=yearChargesheetName]').val();
                $.ajax({
                    url: 'selectChargesheet/' + yearChargesheet,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        makeChargesheetChart(data)
                    },
                    error: function (data) {
                        alert('error occurred! Please Check');
                    }
                });
            });

            function makeChargesheetChart(seriesData) {
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'Year');
                dataTable.addColumn('number', 'Sales');
                // A column for custom tooltip content
                dataTable.addColumn({type: 'string', role: 'tooltip'});
                dataTable.addRows(seriesData);

                var options = {

                    legend: 'none',
                    colors: ['#FFB6C1']
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('col_chart_html_tooltip_chargesheet'));
                chart.draw(dataTable, options);
            }
        }
    </script>
    <div id="col_chart_html_tooltip_chargesheet" style="width: 100%; height: 300px;"></div>
    </div>