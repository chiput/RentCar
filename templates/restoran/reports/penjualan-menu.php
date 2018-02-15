<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Penjualan Menu',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Laporan',
    'submain_location' => 'Penjualan Menu'
  ]); 
?>
<?php
                function convert_date($date){
                    $exp = explode('-', $date);
                    if (count($exp)==3) {
                        $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
                    }
                    return $date;
                }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Laporan Penjualan Menu</h3>
            <p class="text-muted m-b-30"></p>
                <form class="form-horizontal" method="POST">
                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="help"> Tanggal</span></label>
                            <div class="col-md-9">
                            <div class="input-daterange input-group" id="date-range" data-date-format="dd-mm-yyyy">
                                <input  type="text" class="form-control" name="start" value="<?=$d_start?>" >
                                <span class="input-group-addon bg-info b-0 text-white">Sampai</span>
                                <input type="text" class="form-control" name="end" value="<?=$d_end?>">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="form-group col-md-4">
                            <label class="col-md-3 control-label"> <span class="help"> Kategori</span></label>
                            <div class="col-md-9">
                              <select  class="form-control" name='kategoriid'  id='kategoriid'>
                                  <option value="0">Pilih Kategori</option>
                                  <?php
                                  foreach($Menu_kategoris as $Menu_kategori){
                                    if(@$kategori==$Menu_kategori->id){
                                        $selected="selected='selected'";
                                    }else{
                                           $selected="";
                                    }

                                    ?>

                                  <option value="<?=$Menu_kategori->id;?>" <?=$selected;?> ><?=$Menu_kategori->nama;?></option>
                                  <?php } ?>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                        <div class="form-group">
                            <button class="form-control btn btn-info">Filter</button>
                        </div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="white-box">
                <table class="table table-striped myDataTable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach ($menus as  $menu): ?>
                        <tr>
                            <td><?php echo $no; ?>.</td>
                            <td><?php echo $menu->nama; ?></td>
                            <td><?php echo "Rp. ".$this->convert($menu->total); ?></td>
                        </tr>
                    <?php $no++; endforeach; ?>
                    </tbody>                           
                </table>

                <div class="row" style="margin-top: 5px; margin-left: 3px;">
                    <div class="col-md-1">
                        <div class="form-group">
                            <a href=" <?php echo $this->pathFor('penjualanmenu-report-print',['start' => $d_start,'end' => $d_end,'cat' => @$kategori])?>" class="btn btn-default btn-rounded waves-effect waves-light"><span class="btn-label"><i class="fa fa-print"></i></span>Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>