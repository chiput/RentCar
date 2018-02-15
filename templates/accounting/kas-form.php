<?php
$arrtype=["","Kas","Bank"];

  $this->layout('layouts/main', [
    // app profile
    'title' => 'Transaksi '. $arrtype[$type],
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Accounting',
    'submain_location' => 'Transaksi '.$arrtype[$type]
  ]);

$typeTrans = $type;
?>

<div class="row" id="kas-form-input">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Transaksi <?=$arrtype[$type]?></h3>
            <p class="text-muted m-b-30"></p>
            <?php if (!is_null(@$errors)): ?>
            <div>
                <p>
                    Error:
                </p>
                <p>
                    <?php echo implode('<br>', $errors); ?>
                </p>

            </div>
            <?php endif;
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('accounting-kas-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$trans->id ?>" name="id">
            <input type="hidden" class="form-control" value="<?php echo (@$trans->type==""?$type:$trans->type)?>" name="type">

            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo convert_date(@$trans->tanggal) ?>" name="tanggal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                        <div class="col-md-12">
                            <input readonly type="text" class="form-control" value="<?php echo @$trans->nobukti ?>" name="nobukti">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" rows="3" name="remark"><?php echo @$trans->remark?></textarea>
                        </div>
                    </div>

            </div>
            <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Penyetor</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$trans->penyetor ?>" name="penyetor">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Penerima</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$trans->penerima ?>" name="penerima">
                        </div>
                    </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                <table class="table" id="tabledetail">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subtotal=0;
                        if(!is_object(@$trans->details))
                        {
                            @$trans->details=[];
                        }
                        foreach(@$trans->details as $detail){
                        $subtotal+=$detail->nominal;
                            ?>
                        <tr>
                            <td><a href="javascript:void(0)" onclick="deleteRow(this);" data-toggle="tooltip" data-original-title="Tambah"> <i class="fa fa-close"></i> </a></td>
                            <td>
                                <select class="form-control" name="types_id[]" onchange="seltype(this);">
                                    <option value="0"></option>
                                    <?php foreach($types as $type){ ?>
                                    <option
                                        data-deb-id="<?=$type->accdebet_id?>"
                                        data-deb-code="<?=$type->accdebet->code?>"
                                        data-deb-name="<?=$type->accdebet->name?>"
                                        data-kre-id="<?=$type->acckredit_id?>"
                                        data-kre-code="<?=$type->acckredit->code?>"
                                        data-kre-name="<?=$type->acckredit->name?>"
                                        <?=($detail->acckastypes_id==$type->id?'selected="selected"':'')?>
                                    value="<?=$type->id?>">
                                        <?=$type->name?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="accdebet_id[]" value="<?=$detail->acckastype->accdebet_id?>" />
                                <?=$detail->acckastype->accdebet->code?> || <?=$detail->acckastype->accdebet->name?>
                            </td>
                            <td>
                                <input type="hidden" name="acckredit_id[]" value="<?=$detail->acckastype->acckredit_id?>" />
                                <?=$detail->acckastype->acckredit->code?> || <?=$detail->acckastype->acckredit->name?>
                            </td>
                            <td>
                                <textarea class="form-control" name="det_remark[]"><?=$detail->remark?></textarea>
                            </td>
                            <td>
                                <input  type="text" class="form-control" value="<?=$detail->nominal?>" name="nominal[]" onkeyup="totaling()"/>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="hidden" id="copy">
                            <td><a href="javascript:void(0)" onclick="deleteRow(this);" data-toggle="tooltip" data-original-title="Tambah"> <i class="fa fa-close"></i> </a></td>
                            <td>
                                <select class="form-control" name="types_id[]" onchange="window.seltype(this);">
                                    <option value="0"></option>
                                    <?php foreach($types as $type){ ?>
                                    <option
                                        data-deb-id="<?=$type->accdebet_id?>"
                                        data-deb-code="<?=$type->accdebet->code?>"
                                        data-deb-name="<?=$type->accdebet->name?>"
                                        data-kre-id="<?=$type->acckredit_id?>"
                                        data-kre-code="<?=$type->acckredit->code?>"
                                        data-kre-name="<?=$type->acckredit->name?>"
                                        value="<?=$type->id?>">

                                        <?=$type->name?>

                                    </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="acckredit_id[]" value="" />
                            </td>
                            <td>
                                <input type="hidden" name="accdebet_id[]" value="" />
                            </td>
                            <td>
                                <textarea class="form-control" name="det_remark[]"></textarea>
                            </td>
                            <td>
                                <input  type="text" class="form-control" value="" name="nominal[]" onkeyup="totaling()"/>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <a href="javascript:void(0)" onclick="newRow();" data-toggle="tooltip" data-original-title="Tambah"> <i class="fa fa-plus-circle"></i> </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Subtotal</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" value="<?php echo @$subtotal ?>" name="subtotal" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?php echo $this->pathFor('accounting-kas',["type"=>strtolower($arrtype[$typeTrans])]); ?>">Batal</a>
            </form>
        </div>
    </div>
</div>
