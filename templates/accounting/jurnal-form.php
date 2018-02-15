<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Jurnal',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Jurnal'
  ]);
?>

<?php if (@$errors!=""): ?>
<div class="row">
    <div class="alert alert-danger alert-dismissable col-sm-12">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php foreach($errors as $error){
            echo $error."<br>";
        } ?>
    </div>
</div>
<?php endif; ?>

<div class="row" id="accounting-jurnal">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Jurnal Umum</h3>
        <p class="text-muted m-b-20 font-13"> </p>

        <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>

        <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-jurnal-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$jurnal->id?>" name="id">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?=convert_date(@$jurnal->tanggal)?>" name="tanggal">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Jurnal</span></label>
                <div class="col-md-12">
                <input readonly type="text" class="form-control" value="<?=@$jurnal->code?>" name="code">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$jurnal->nobukti?>" name="nobukti">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                <div class="col-md-12">
                <input type="text" class="form-control" value="<?=@$jurnal->keterangan?>" name="keterangan">
                </div>
            </div>
        </div>
        <table class="table table-bordered" id="table-account">
            <thead>
                <tr>
                    <th></th>
                    <th>Kode</th>
                    <th>Akun</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if(@$jurnal->detail != ''){
                foreach(@$jurnal->detail as $detail){
            ?>
            <tr>
                <td>
                    <a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                </td>
                <td>
                    <input type="hidden" name="account_id[]" value="<?=$detail->id?>" />
                    <?=$detail->account->code?>
                </td>
                <td>
                    <?=$detail->account->name?>
                </td>
                <td>
                    <input type="text" name="debet[]" value="<?=$detail->debet?>" class="form-control"/>
                </td>
                <td>
                    <input type="text" name="kredit[]" value="<?=$detail->kredit?>" class="form-control"/>
                </td>
            </tr>
            <?php
                }
            } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <a href="#" alt="default" data-toggle="modal" data-target="#accounts-modal" class="model_img img-responsive">Tambah Account</a>
                    </td>
                </tr>
            </tfoot>
        </table>

        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
        <a class="btn btn-danger waves-effect waves-light m-r-10" href="javascript:window.history.back();">Batal</a>

        </form>
      </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="accounts-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Daftar Account</h4>
            </div>
            <div class="modal-body">
                <table class="table myDataTable">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($accounts as $account){ ?>
                        <tr>
                            <td><a href="javascript:void(0)" data-id="<?=$account->id?>" data-code="<?=$account->code?>" data-name="<?=$account->name?>" data-dismiss="modal"><?=$account->code?></a></td>
                            <td><?=$account->name?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>