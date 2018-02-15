<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Form Biaya Tambahan',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Frontdesk',
    'submain_location' => 'Biaya Tambahan'
  ]);

//echo ($checkins);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Form Biaya Tambahan</h3>
            <p class="text-muted m-b-30"></p>
            <?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
            ?>
            <?php if (!is_null($errors)): ?>
            <div>
                <p>
                    Error:
                </p>
                <p>
                    <?php echo implode('<br>', $errors); ?>
                </p>
            </div>
            <?php endif; ?>
            <form class="form-horizontal" action="<?php echo $this->pathFor('frontdesk-addcharge-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$addcharge->id ?>" name="id">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Tanggal</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control mydatepicker" data-date-format="dd-mm-yyyy" value="<?php echo convert_date(@$addcharge->tanggal) ?>" name="tanggal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                        <div class="col-md-12">
                            <input readonly type="text" class="form-control" value="<?php echo @$addcharge->nobukti ?>" name="nobukti">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Kamar</span></label>
                        <div class="col-md-12">
                            <select class="form-control select2" name="reservationdetails_id">
                                <option value="0">- Pilih Tamu / Kamar -</option>
                                <?php foreach($checkins as $checkin){ 

                                    if(@$checkin->id == @$addcharge->reservationdetails_id || @$checkin->checkout_at == null){

                                    ?>
                                <option value="<?=$checkin->id?>" 
                                    <?=(@$checkin->id==@$addcharge->reservationdetails_id?'selected="selected"':'')?>
                                >
                                    <?=$checkin->checkin_code?> | <?=$checkin->room->number?> | <?=$checkin->reservation->guest->name?> <?=$checkin->checkout_at != null?"(Check Out)":""?>
                                </option>
                                <?php 
                                        }
                                    } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12"> <span class="help"> Keterangan</span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" name="remark"> <?php echo @$addcharge->remark ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                <table class="table" id="tabledetail">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Kode / Nama</th>
                            <th>Keterangan</th>
                            <th width="100">Jumlah</th>
                            <th width="100">Harga</th>
                            <th width="100">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $subtotal=0;
                        if(!is_object(@$addcharge->detail))
                        {
                            @$addcharge->detail=[];
                        } 
                        foreach(@$addcharge->detail as $detail){
                        $subtotal+=$detail->sell;
                            ?>
                        <tr>
                            <td><a href="javascript:void(0)" onclick="deleteRow(this);" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close"></i> </a></td>
                            <td>
                                <select class="form-control" name="types_id[]" onchange="window.seltype(this);">
                                    <option value="0"></option>
                                    <?php foreach($types as $type){ ?>
                                    <option 
                                    <?=($detail->addchargetypes_id==$type->id?'selected="selected"':'')?>
                                    data-sell="<?=$type->sell?>" 
                                    data-editable="<?=$type->is_editable?>" 
                                    value="<?=$type->id?>">
                                        <?=$type->code?> / <?=$type->name?>
                                    </option>
                                    <?php } ?>
                                </select> 
                            </td>
                            <td>
                                <textarea class="form-control" name="remarks[]"><?=$detail->remark?></textarea>
                            </td>
                            <td>
                                <input  type="number" class="form-control" onchange="totaling()" onkeyup="totaling()" value="<?=$detail->qty?>"
                                 name="qty[]"/>
                            </td>
                            <td>
                                <input  type="text" <?=$detail->addchargetype->is_editable?'':'readonly="readonly"'?> class="form-control sell" value="<?=$detail->sell?>" name="sell[]" onchange="totaling()" onkeyup="totaling()"  />
                            </td>
                            <td>
                                <input  type="text" readonly="readonly" class="form-control subtotal" value="<?=$detail->sell*$detail->qty?>" name="sub[]"/>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="hidden" id="copy">
                            <td><a href="javascript:void(0)" onclick="deleteRow(this);" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close"></i> </a></td>
                            <td>
                                <select class="form-control" name="types_id[]" onchange="window.seltype(this);">
                                    <option value="0"></option>
                                    <?php foreach($types as $type){ ?>
                                    <option value="<?=$type->id?>"
                                        data-sell="<?=$type->sell?>" 
                                        data-editable="<?=$type->is_editable?>" 
                                    >
                                        <?=$type->code?> / <?=$type->name?>
                                    </option>
                                    <?php } ?>
                                </select> 
                            </td>
                            <td>
                                <textarea class="form-control" name="remarks[]"></textarea>
                            </td>
                            <td>
                                <input  type="number" class="form-control" onchange="totaling()" onkeyup="totaling()" value="1" name="qty[]"/>
                            </td>
                            <td>
                                <input type="text" onchange="totaling()" onkeyup="totaling()" readonly="readonly"  class="form-control sell" value="" name="sell[]"/>
                            </td>
                            <td>
                                <input  type="text" readonly="readonly"  class="form-control subtotal" value="" name="sub[]"/>
                            </td>
                        </tr>                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
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
                        <label class="col-md-12"> <span class="help"> Total</span></label>
                        <div class="col-md-12">
                            <input type="text" readonly="readonly" class="form-control" value="" name="total">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                    <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('frontdesk-addcharge')?>">Batal</a>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=$this->baseUrl()?>js/addcharge-form.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        totaling();
        var format = new curFormatter();
        format.input('.sell');
    });
</script>