<div class="col-lg-6 col-xs-6">

    <div style="text-align: right; background: white;">
        <div style="text-align: center; font-size:20px;"><b>Case Chart</b></div>
        <label>Select year:</label>
        <select name="year" id="year">
            @foreach($quryYear as $quryYear)
                <option value="{{ $quryYear->year }}"> {{ $quryYear->year }} </option>
            @endforeach
        </select>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">


        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            makeChart(<?=json_encode($dataCase)?>);

            $('#year').on('change', function (e) {
                var yearId = $('select[name=year]').val();
                $.ajax({
                    url: 'selectCase/' + yearId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        makeChart(data)
                    },
                    error: function (data) {
                        alert('error occurred! Please Check');
                    }
                });
            });
            function makeChart(seriesData) {
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'Year');
                dataTable.addColumn('number', 'Sales');
                // A column for custom tooltip content
                dataTable.addColumn({type: 'string', role: 'tooltip'});
                dataTable.addRows(seriesData);

                var options = {

                    legend: 'none'
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('col_chart_html_tooltip'));

                google.visualization.events.addListener(chart, 'select', selectHandler);

                function selectHandler() {
                    var selection = chart.getSelection();
                    console.log(selection);
                    var lat = dataTable.getValue(selection[0].row, 0); // HERE is where I get the value!
                    var lon = dataTable.getValue(selection[0].row, 1);
                    var id = dataTable.getValue(selection[0].row, 2);

                    var total=  lat + "/" +id;
                    var url = "<?php echo url('caseDetails/'); ?>" +total;
                   // alert(url);
                    window.open('<?php echo url('caseChartDetails/'); ?>/'+total,'_blank');
                }
                chart.draw(dataTable, options);
            }
        }
        </script>
    <div id="col_chart_html_tooltip" style="width: 100%; height: 300px;">

    </div>

</div>
