<section class="content-header">
      <h1>
        Akun
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-user"></i> Akun</li>
        <li class="active"><i class="fa fa-pencil"></i> Ubah Password</li>
      </ol>
    </section>

<section class="content">
<div class="box box-primary">
    <div class="box-header with-border">
        Form Ubah Password
     <div id="info-alert"><?=@$this->session->flashdata('status')?></div>
    </div>
    <div class="box-body">
        <form action="<?=base_url()?>akun/ubah" method="post">
            <div class="form-group">
                <label for="">Password lama</label>
                <input type="password" required class="form-control" name="old">
            </div>
            <div class="form-group">
                <label for="">Password Baru</label>
                <input type="password" required class="form-control" name="new">
            </div>
            <div class="form-group">
                <label for="">Password Konfirmasi</label>
                <input type="password" required class="form-control" name="new_konf">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Ubah</button>
            </div>
        </form>
                
    </div>
</div>

</section>
