<section class="content-header">
    <h1>
    Akun
    </h1>
    <ol class="breadcrumb">
    <li><i class="fa fa-user"></i> Akun</li>
    <li class="active"><i class="fa fa-bell"></i> Notifikasi</li>
    </ol>
</section>

<section class="content">
<div class="box box-primary">
    <div class="box-header with-border">
        Notifikasi
     <div id="info-alert"><?=@$this->session->flashdata('status')?></div>
    </div>
    <div class="box-body">
        <center> 
            <div id="loaderNotif">
                <img width="100" src="<?=base_url()?>assets/loader.gif" alt="">
                <p class="text text-info">Sedang memproses Mesin Notifikasi, Pastikan Koneksi INTERNET stabil.</p>
            </div>
            <a href="#" id="my-notification-button" class="btn btn-primary" style="display: none;">Subscribe to Notifications</a>
        </center>
        <br>
        <div class="alert alert-info">Push Notifikasi anda akan dialihkan ke Device yang terakhir dikaitkan.</div>
        <hr>        
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Isi</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; if(!empty($table)){foreach($table as $row){ ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$row->notifikasiIsi?></td>
                    <td><?=date('d M Y - H:i:s',strtotime($row->notifikasiCreatedAt))?></td>
                </tr>
            <?php }}?>
            </tbody>
        </table>
        </div>
    </div>
</div>

</section>


