<div class="col-lg-12 col-xs-12">

<script>


</script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">






        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            makeConvictChart(<?=json_encode($ConvictGenderData)?>);

            $('#convictYear').on('change', function(e) {
                var convictYearId = $('select[name=convictYearName]').val();
                $.ajax({
                    url: 'selectConvict/'+convictYearId,
                    type: 'GET',
                    dataType:'json',
                    success: function(data) {
                        console.log(data);
                        makeConvictChart(data)
                    },
                    error: function(data) {
                        alert('error occurred! Please Check');
                    },
                });
            });
            // Some raw data (not necessarily accurate)
//            var data = google.visualization.arrayToDataTable([
//                ['Month', 'Female', 'Male'],
//                ['Januery',  165,      938],
//                ['2004/05',  165,      938],
//
//            ]);
            function makeConvictChart(seriesData) {
                var data = google.visualization.arrayToDataTable(seriesData);


            var options = {
                title: 'Gender Wise Convict Chart',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
        }
    </script>
    <div style="text-align: right; background: white;">

        <label>Select year:</label>
        <select name="convictYearName" id="convictYear">
            @foreach($quryYear as $quryYear)
                <option value="{{ $quryYear->year }}"> {{ $quryYear->year }} </option>
            @endforeach
        </select>
    </div>
<div id="curve_chart" style="width: 100%; height: 300px;">

    </div>

</div>
