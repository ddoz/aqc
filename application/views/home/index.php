<style>
    .highcharts-figure,
.highcharts-data-table table {
  min-width: 310px;
  max-width: 800px;
  margin: 1em auto;
}

#container {
  height: 400px;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ebebeb;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}

.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}

.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
  padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}

.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>
<section class="content">
<div class="box box-secondary">
    <div class="box-header with-border">
     <div id="info-alert"><?=@$this->session->flashdata('status_crud')?></div>
    </div>
    <div class="box-body">
        <div class="col-md-12 text-center">
            <?php if(!empty($hasil)) { ?>
               <div class="alert alert-info text-center"><b> PERIODE : <?php echo $hasil['periode']->nama_periode; ?></b></div>

               
               <div class="box">
                   <div class="box-body">

                       TOTAL PEMILIH : <?php echo $hasil['pemilih']->total; ?> PEMILIH<br>
                       DATA MASUK :  <?php $total_suara = 0; foreach($hasil['hasil'] as $hsl) { $total_suara += $hsl->jumlah_suara; } echo $total_suara;?><br>
                       PERSENTASE DATA MASUK : <?php $persen = (int)$total_suara / (int)$hasil['pemilih']->total * 100; echo $persen."%";?>
                   </div>
               </div>
               
               <div class="row">
               <?php foreach($hasil['hasil'] as $hsl) { ?>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-body">
                            <?php
                                $source_a = $hsl->poto_a;
                                $source_b = $hsl->poto_b;
                            if($hsl->poto_a=="") { 
                                $source_a = "assets/user_default.png";
                             }
                             if($hsl->poto_b=="") { 
                                $source_b = "assets/user_default.png";
                             }
                             ?>
                             <img src="<?=base_url().$source_a?>" width="100" alt="">
                             <img src="<?=base_url().$source_b?>" width="100" alt="">
                        </div>
                        <div class="box-footer text-center">
                            <?=$hsl->nama_kandidat?>
                            <?php if($hsl->nama_pasangan!=""){ ?>
                                - <?=$hsl->nama_pasangan?>
                            <?php }?>
                            <hr>
                            Jumlah Suara Masuk : <?=$hsl->jumlah_suara?>
                        </div>
                    </div>
                </div>
                <?php }?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="box box-secondary">
    <div class="box-body">
        <div class="col-md-6 text-center">

        <div id = "container"></div>

        </div>
        <div class="col-md-6">
            <figure class="highcharts-figure">
            <div id="container2"></div>
            </figure>
        </div>
    </div>
</div>

</section>