<?php
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Reservasi',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Restoran',
    'submain_location' => 'Form Reservasi'
  ]);
?>

<?php if ($this->getSessionFlash('error')): ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('error'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Reservasi || Booking </h3>
            <p class="text-muted m-b-30">Form Reservasi</p>
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
            <form class="form-horizontal" action="<?php echo $this->pathFor('booking-save'); ?>" method="post">
            <input type="hidden" class="form-control" value="<?php echo @$resbooking->id; ?>" name="id">

            <div class="row">
                <div class="col-md-6">
                    <h3 class="box-title"> Data Reservasi</h3>
                    <hr />

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> No. Bukti</span></label>
                            <div class="col-md-12">
                                <input readonly type="text" class="form-control" value="<?php if(@$Respesanan->nobukti){echo @$Respesanan->nobukti;}else{ echo @$NoBukti;}  ?><?= @$resbooking->nobukti?>" name="nobukti">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"> <span class="help"> Tanggal Check In</span></label>
                            <div class="col-md-12">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo convert_date(substr((@$resbooking->checkin == '' ? date('Y-m-d') : @$resbooking->checkin),0,10)) ?>" name="tanggal_checkin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"><span class="help">Tamu Resto</span></label>
                                <div class="col-md-12">
                                    <select name="pelanggan_id" class="form-control select2">
                                    <option value="0"> -- Pilih Tamu -- </option>
                                    <?php foreach($pelanggans as $pelanggan){ ?>
                                        <option value="<?=@$pelanggan->id?>" 
                                        <?=(@$resbooking->pelanggan_id == $pelanggan->id ? 'selected="selected"' : '') ?> 
                                        ><?=@$pelanggan->nama?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"><span class="help">Pax</span></label>
                                <div class="col-md-12">
                                    <input type="text" name="pax" class="form-control" value="<?php echo @$resbooking->pax; ?>">
                                </div>
                        </div>
                            <div class="form-group">
                                <label class="col-md-12"><span class="help">Meja</span></label>
                                <div class="col-md-12">
                                    <select name="meja_id" class="form-control select2">
                                    <option value="0"> -- Pilih Meja -- </option>
                                    <?php foreach($mejas as $meja){ ?>
                                        <option value="<?=@$meja->id?>" 
                                        <?=(@$resbooking->meja_id == $meja->id ? 'selected="selected"' : '') ?> 
                                        ><?=@$meja->kode_meja?> | <?=@$meja->tipe_meja?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                       <div class="form-group">
                            <label class="col-md-12"><span class="help">Tanggal</span></label>
                                <div class="col-md-12">
                                    <input type="text" data-date-format="dd-mm-yyyy" class="form-control mydatepicker" value="<?php echo convert_date(substr((@$resbooking->tanggal == '' ? date('Y-m-d') : @$resbooking->tanggal),0,10)) ?>" name="tanggal">
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"><span class="help">Jam</span></label>
                            <div class="col-md-12">
                                <input type="text" data-placement="bottom" name="jam" data-autoclose="true" class="form-control clockpicker" value="<?=@ $resbooking->jam == ""?date('H:i'):@$resbooking->jam; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"><span class="help">Tamu Hotel</span></label>
                            <div class="col-md-12">
                            <select name="guest_id" class="form-control select2">
                            <option value='0'> -- Pilih Tamu -- </option>
                            <?php foreach($Rooms as $Room) { 
                                if(@$resbooking->rooms_id==$Room->id){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }?>
                              <option value="<?=$Room->id?>" <?= $selected; ?>> <?= $Room->reservation->guest->name?></option>
                              <?php } ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"><span class="help">Status</span></label>
                            <div class="col-md-12">
                                <select class="form-control" name="status">
                                    <option value="0"> -- Pilih Status -- </option>
                                    <option value="1" <?=@$reservation->status==1?'selected="selected"':''?> >Reservasi</option>
                                    <option value="2" <?=@$reservation->status==2?'selected="selected"':''?> >Check In</option>
                                    <option value="3" <?=@$reservation->status==3?'selected="selected"':''?>>Batal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="col-md-6">
                    <h3 class="box-title"> Data Meja</h3>
                        <hr />
                    <?php foreach ($mejas as $meja): ?>
                        <span class="button-checkbox">
                            <button type="button" data-color="btn-info" class="item" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $meja->tipe_meja ?> - <?php echo $meja->max_tamu?> orang"><?php echo $meja->kode_meja ?></button>
                            <input type="checkbox" class="hidden" name="mejas[]" value="<?php echo $meja->id ?>" />
                        </span>
                     <?php endforeach; ?>
            </div>
            </div>
            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
            <a class="btn btn-danger waves-effect waves-light m-r-10" href="<?=$this->pathFor('booking')?>">Batal</a>

            </form>
        </div>
    </div>
</div>
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
<style type="text/css">
    /*.btn-grid {
      width:526px;
      background-color:black;
    }*/
    /*.item {
      color:#fff;
      font-size:10px;
      text-transform:uppercase;
      background-color:#D9651A;
      font-family: 'Quicksand', sans-serif;
      border:0px;
      margin:2px;
      border-radius: 5px;
      height:90px;
      width:90px;
      -webkit-transition: all 0.1s ease;
     transition: all 0.1s ease; 
    }
    .item:hover {
    background-color: #EA8B1D;
    box-shadow: 0 10px 15px rgba(0,0,0,0.3);
    -webkit-transform: translate3d(-1px, -2px, 0);
    transform: translate3d(-1px, -2px, 0);
    }*/
</style>
<script type="text/javascript">
    $(function () {
    $('.button-checkbox').each(function () {
            // Settings
            var $widget = $(this),
                $button = $widget.find('button'),
                $checkbox = $widget.find('input:checkbox'),
                color = $button.data('color'),
                settings = {
                    on: {
                        icon: 'glyphicon glyphicon-check'
                    },
                    off: {
                        icon: 'glyphicon glyphicon-unchecked'
                    }
                };

            // Event Handlers
            $button.on('click', function () {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
                $checkbox.triggerHandler('change');
                updateDisplay();
            });
            $checkbox.on('change', function () {
                updateDisplay();
            });

            // Actions
            function updateDisplay() {
                var isChecked = $checkbox.is(':checked');

                // Set the button's state
                $button.data('state', (isChecked) ? "on" : "off");

                // Set the button's icon
                $button.find('.state-icon')
                    .removeClass()
                    .addClass('state-icon ' + settings[$button.data('state')].icon);

                // Update the button's color
                if (isChecked) {
                    $button
                        .removeClass('btn-default')
                        .addClass('btn-' + color + ' active');
                }
                else {
                    $button
                        .removeClass('btn-' + color + ' active')
                        .addClass('btn-default');
                }
            }

            // Initialization
            function init() {

                updateDisplay();

                // Inject the icon if applicable
                if ($button.find('.state-icon').length == 0) {
                    $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                }
            }
            init();
        });
      });
</script>
