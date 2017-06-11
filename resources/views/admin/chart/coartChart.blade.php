<div class="col-lg-6 col-xs-6">






    <div id='myCoartChart' style='background: white;'>
        <div id="yearclass">
            <div style="text-align: center; font-size:20px;"><b>Coart Chart</b></div>
            <label>Select year:</label>
            <select name="yearName" id="yearId">
                @foreach($quryYearCoart as $quryYearCoart)
                    <option value="{{ $quryYearCoart->year }}"> {{ $quryYearCoart->year }} </option>
                @endforeach
            </select>
        </div>

    </div>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);



            function drawChart() {
                makeCoartChart(<?=json_encode($dataCoart)?>);

                $('#yearId').on('change', function(e) {
                    var yearId = $('select[name=yearName]').val();
                    $.ajax({
                        url: 'selectCoart/'+yearId,
                        type: 'GET',
                        dataType:'json',
                        success: function(data) {
                            console.log(data);
                            makeCoartChart(data)
                        },
                        error: function(data) {
                            alert('error occurred! Please Check');
                        }
                    });
                });


                function makeCoartChart(seriesData) {
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'Year');
                dataTable.addColumn('number', 'Sales');
                // A column for custom tooltip content
                dataTable.addColumn({type: 'string', role: 'tooltip'});
                dataTable.addRows(seriesData);

                var options = { legend: 'none',colors: ['#DAA520'] };
                var chart = new google.visualization.ColumnChart(document.getElementById('tooltip_action'));
                chart.draw(dataTable, options);
            }
        }


    </script>
    <div id="tooltip_action" style="width: 100%; height: 300px;"></div>
</div>