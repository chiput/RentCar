<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Pemakaian Barang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],

  ]);

  function convert_date($date){
            $exp = explode('-', $date);
            if (count($exp)==3) {
             
                $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
            }
            return $date;
        }
  //echo($usage->details);
  // echo "<pre>";
  // print_r($stock['categories']);
  // echo "</pre>";

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

<div class="row" id="logistic-usage-app">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title m-b-0">Form Pemakaian Barang</h3>
        <p class="text-muted m-b-20 font-13"> </p>
        <form class="form-horizontal" action="<?php echo $this->pathFor('logistic-usage-save') ?>" method="POST">
        <input type="hidden" class="form-control" value="<?=@$usage->id?>" name="id">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                <div class="col-md-12">
                <input readonly type="text" class="form-control" value="<?=@$usage->nobukti?>" name="nobukti">
                <input type="text" class="form-control hidden" value="<?=@$gudminta?>" name="gudminta">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Gudang</span></label>
                <div class="col-md-12">
                <select class="form-control" name="gudang_id" readonly="readonly">
                <?php foreach($warehouses as $warehouse){ ?>
                    <option value="<?=@$warehouse->id?>"
                    <?=(@$usage->gudang_id == $warehouse->id ? 'selected="selected"' : '') ?>
                    ><?=@$warehouse->nama?> | <?=@$warehouse->department->name?></option>
                <?php } ?>
                </select>
                </div>
            </div>

        </div>
        <div class="col-sm-6">

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                <div class="col-md-12">
                <input type="text" readonly="readonly" class="form-control" value="<?=convert_date(@$usage->tanggal)? date('d-m-Y'):convert_date(@$usage->tanggal)?>" name="tanggal" data-date-format="dd-mm-yyyy">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                <div class="col-md-12">
                <textarea class="form-control" rows="3" name="keterangan"><?=@$usage->keterangan?></textarea>
                </div>
            </div>

        </div>
        <div class="col-sm-12">
            <h3 class="box-title m-b-0">Barang</h3>
            <table class="table table-bordered table-striped" id="tabledetail">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Kuantitas</th>
                        <!--<th>Harga</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(@$usage->details != ''){
                    foreach(@$usage->details as $detail){ ?>
                    <tr>
                        <td>
                            <a href="#" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a>
                        </td>
                        <td>
                            <input type="hidden" name="barang_id[]" value="<?=$detail->barang_id?>">
                            <?=$detail->good->nama?>
                        </td>
                        <td>
                            <input name="satuan_id[]" value="<?=$detail->satuan_id?>" type="hidden"/>
                            <?=$detail->good->unit->nama?>
                        </td>
                        <td>
                            <input type="number" name="kuantitas[]" value="<?=$detail->kuantitas?>" class="form-control" step="0.001"/>
                        </td>
                        <!--<td>
                            <input type="text" name="hargastok[]" value="<?=number_format($detail->good->hargastok,0,",",".")?>" class="form-control" readonly="readonly"/>
                        </td>-->
                    </tr>
                    <?php }
                    }
                    ?>
                    <?php
                    if(@$request != ''){
                    foreach(@$request as $detail){ ?>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="barang_id[]" value="<?=$detail->barang_id?>">
                            <?=$detail->good->nama?>
                        </td>
                        <td>
                            <input name="satuan_id[]" value="<?=$detail->satuan_id?>" type="hidden"/>
                            <?=$detail->unit->nama?>
                        </td>
                        <td>
                            <input type="number" name="kuantitas[]" value="<?=$detail->kuantitas?>" class="form-control" step="0.001"/>
                        </td>
                    </tr>
                    <?php }
                    }
                    ?>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <td colspan="6">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#goods-modal" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                        </td>
                    </tr>
                </tfoot> -->
            </table>

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-t-10" href="<?=$this->pathFor('logistic-usage')?>">Batal</a>
                </div>
            </div>

        </div>


        <div class="form-group m-b-0">

        </div>

        </form>
      </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="goods-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Daftar Barang</h4>
            </div>
            <div class="modal-body">
                <table class="table myDataTable">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Minimal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($stock['categories'] as $cat){ ?>
                            <?php foreach($cat->goods as $good){
                                    if(isset($stock['totals'][$good->id])){
                            ?>
                                <tr>
                                    <td><a href="javascript:void(0)"
                                    data-id="<?=$good->id?>"
                                    data-unitid="<?=$good->unit->id?>"
                                    data-unitname="<?=$good->unit->nama?>"
                                    data-hargastok="<?=number_format($good->hargastok,"0",",",".")?>"
                                    data-stock="<?=$stock['totals'][$good->id]["total"]?>"
                                    data-dismiss="modal"><?=$good->nama?></a></td>
                                    <td><?=$good->unit->nama?></td>
                                    <td><?=$stock['totals'][$good->id]["total"]?></td>
                                    <td><?=number_format($good->hargastok,0,",",".")?></td>
                                    <td><?=$stock['totals'][$good->id]["minimal"]?></td>
                                </tr>
                                    <?php }
                                } ?>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<input type="hidden" id="listUnits" value='<?=$units?>'/>
<input type="hidden" id="listAccounts" value='<?=$accounts?>'/>
    <!-- /.modal-dialog -->