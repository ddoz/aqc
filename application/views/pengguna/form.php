<section class="content-header">
      <h1>
        Pengguna
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-envelope"></i> Admin</li>
        <li class="active"><i class="fa fa-plus"></i> Pengguna</li>
      </ol>
    </section>

<section class="content">
<div class="box box-primary">
    <div class="box-header with-border">
        Form untuk menambahkan Pengguna.
        <div class="pull-right">
            <a href="<?=base_url()?>pengguna" class="btn btn-warning"><i class="fa fa-arrow-left"></i></a>
        </div>
     <div id="info-alert"><?=@$this->session->flashdata('status')?></div>
    </div>
    <div class="box-body">
        <form method="POST" action="<?=base_url()?>pengguna/save" target="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Pilih Level</label>
                <select name="level" id="" class="form-control" required>
                    <option value="">Pilih Level</option>
                    <option value="0">Biasa</option>
                    <option value="3">Admin</option>
                    <option value="2">KADIS</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" name="cetak" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
            </div>
        </form>
    </div>
</div>
</section>
