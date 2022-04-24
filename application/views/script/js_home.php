<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script language = "JavaScript">
    <?php if(!empty($hasil)) { 
        $total_pemilih = $hasil['pemilih']->total;
        $pemilih = 0; foreach($hasil['hasil'] as $hsl) { $pemilih += $hsl->jumlah_suara; }
        $sisa = $total_pemilih - $pemilih;
        ?>
         $(document).ready(function() {
            var chart = {
               plotBackgroundColor: null,
               plotBorderWidth: null,
               plotShadow: false
            };
            var title = {
               text: 'Grafik Pemungutan Suara'   
            };
            var tooltip = {
               pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            };
            var plotOptions = {
               pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  
                  dataLabels: {
                     enabled: true,
                     format: '<b>{point.name}%</b>: {point.percentage:.1f} %',
                     style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor)||
                        'black'
                     }
                  }
               }
            };
            var series = [{
               type: 'pie',
               name: 'Pemungutan Suara',
               data: [
                  ['Pemilih',   <?=$pemilih?>],
                  ['Belum Memilih',       <?=$sisa?>]
               ]
            }];
            var json = {};   
            json.chart = chart; 
            json.title = title;     
            json.tooltip = tooltip;  
            json.series = series;
            json.plotOptions = plotOptions;
            $('#container').highcharts(json);  
         });

         <?php }?>
      </script>

<?php if(!empty($hasil)) { ?>
<script>
 $(document).ready(function() {  
            var chart = {
               type: 'column'
            };
            var title = {
               text: 'Grafik Per Kandidat'   
            };
            var subtitle = {
               text: 'Source: Surveyor AQC'  
            };
            var xAxis = {
               categories: ['Suara Masuk'],
               crosshair: true
            };
            var yAxis = {
               min: 0,
               title: {
                  text: 'Jumlah Suara'         
               }      
            };
            var tooltip = {
               headerFormat: '<span style = "font-size:10px">{point.key}</span><table>',
               pointFormat: '<tr><td style = "color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style = "padding:0"><b>{point.y}</b></td></tr>',
               footerFormat: '</table>',
               shared: true,
               useHTML: true
            };
            var plotOptions = {
               column: {
                  pointPadding: 0.2,
                  borderWidth: 0
               }
            };  
            var credits = {
               enabled: false
            };
            var series= [
                <?php foreach($hasil['hasil'] as $hsl){ ?>
               {
                  name: '<?=$hsl->nama_kandidat?>
                            <?php if($hsl->nama_pasangan!=""){ ?>
                                - <?=$hsl->nama_pasangan?>
                            <?php }?>',
                  data: [<?=$hsl->jumlah_suara?>]
               }, 
               <?php }?>
            ];     
         
            var json = {};   
            json.chart = chart; 
            json.title = title;   
            json.subtitle = subtitle; 
            json.tooltip = tooltip;
            json.xAxis = xAxis;
            json.yAxis = yAxis;  
            json.series = series;
            json.plotOptions = plotOptions;  
            json.credits = credits;
            $('#container2').highcharts(json);
  
         });
</script>
<?php }?>