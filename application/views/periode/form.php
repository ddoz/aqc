<section class="content-header">
      <h1>
        Form Periode
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-envelope"></i> Admin</li>
        <li class="active"><i class="fa fa-plus"></i> Form Periode</li>
      </ol>
    </section>

<section class="content">
<div class="box box-secondary">
    <div class="box-header with-border">
        Form untuk menambahkan Periode.
        <div class="pull-right">
            <a href="<?=base_url()?>periode" class="btn btn-warning"><i class="fa fa-arrow-left"></i></a>
        </div>
     <div id="info-alert"><?=@$this->session->flashdata('status')?></div>
    </div>
    <div class="box-body">
        <form method="POST" action="<?=base_url()?>periode/save" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Nama Periode</label>
                <input type="text" name="nama_periode" required class="form-control">
            </div>
            <div class="form-group">
                <label for=""W>Tingkat Wilayah</label>
                <input type="text" name="label_wilayah" required class="form-control">
            </div>
            <div class="form-group">
                <label for="">Wilayah</label>
                <select name="wilayah_id" required class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Tanggal</label>
                <input type="text" name="tanggal" required class="form-control datepicker">
            </div>
            <div class="form-group">
                <label for="">Status Periode</label>
                <select name="status" required class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
            </div>
        </form>
    </div>
</div>
</section>
