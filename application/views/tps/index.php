<section class="content-header">
      <h1>
        TPS
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-envelope"></i> Admin</li>
        <li class="active"><i class="fa fa-plus"></i> TPS</li>
      </ol>
    </section>

<section class="content">
<div class="box box-secondary">
    <div class="box-header with-border">
        Data TPS.
        <div class="pull-right">
            <a href="" class="btn btn-success"><i class="fa fa-plus"></i></a>
        </div>
     <div id="info-alert"><?=@$this->session->flashdata('status')?></div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover exporting-table">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>Nama TPS</th>
                    <th>Wilayah</th>
                    <th>Periode</th>
                    <th>Jumlah Pemilih</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; if(!empty($table)) { foreach($table as $row){ ?>
                <tr>
                    <td><?=$i++?></td>
                    <td><?=$row->nama_tps?></td>
                    <td><?=$row->wilayah_id?></td>
                    <td><?=$row->periode_id?></td>
                    <td><?=$row->jumlah_pemilih?></td>
                    <td>
                        <button type="button" data-id="<?=$row->id?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button>
                        <a onclick="" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus Data</a>
                    </td>
                </tr>
            <?php }}?>
            </tbody>
        </table>
        </div>
    </div>
</div>
</section>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="<?=base_url()?>periode/update" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Edit</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label for="">Waktu Mulai</label>
                <input type="hidden" name="id" id="id" required>
                <input type="text" name="waktu_mulai" id="waktu_mulai" required class="form-control datepicker">
            </div>
            <div class="form-group">
                <label for="">Waktu Selesai</label>
                <input type="text" name="waktu_selesai" id="waktu_selesai" required class="form-control datepicker">
            </div>
            
            <div class="form-group">
                <label for="">Waktu Selesai</label>
                <select name="status_jadwal" id="status_jadwal" required class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>

  </div>
</div>