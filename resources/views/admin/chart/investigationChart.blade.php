<div class="col-lg-6 col-xs-6">






    <div id='myInvestigationChart' style='background: white;'>
        <div style="text-align: center; font-size:20px;"><b>Investigation Chart</b></div>
        <div id="yearclass">
            <label>Select year:</label>
            <select name="yearInvestigationName" id="yearInvestigation">
                @foreach($quryYearInvestigation as $quryYearInvestigation)
                    <option value="{{ $quryYearInvestigation->year }}"> {{ $quryYearInvestigation->year }} </option>
                @endforeach
            </select>
        </div>

    </div>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        makeInvestigationChart(<?=json_encode($dataInvestigation)?>);

        $('#yearInvestigation').on('change', function(e) {
            var yearInvestigation = $('select[name=yearInvestigationName]').val();
            $.ajax({
                url: 'selectInvestigation/'+yearInvestigation,
                type: 'GET',
                dataType:'json',
                success: function(data) {
                    console.log(data);
                    makeInvestigationChart(data)
                },
                error: function(data) {
                    alert('error occurred! Please Check');
                }
            });
        });


        function makeInvestigationChart(seriesData) {


                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'Year');
                dataTable.addColumn('number', 'Sales');
                // A column for custom tooltip content
                dataTable.addColumn({type: 'string', role: 'tooltip'});
                dataTable.addRows(seriesData);

                var options = { legend: 'none' ,colors: ['#FF6347']};
                var chart = new google.visualization.ColumnChart(document.getElementById('tooltip_action_investigation'));
                chart.draw(dataTable, options);
            }
        }


    </script>
    <div id="tooltip_action_investigation" style="width: 100%; height: 300px;"></div>
</div>