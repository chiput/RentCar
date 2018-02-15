<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Mata Uang',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'Akunting',
    'submain_location' => 'Daftar Mata Uang'
  ]); 
?>

<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>
<?php if ($this->getSessionFlash('error_messages')): ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('error_messages'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box" id="currency-app">
            <h3 class="box-title m-b-0">Mata Uang</h3>
            <p class="text-muted m-b-30">Data mata uang</p>
            <p><a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#currencyModal" v-on:click="addItem">Tambah Mata Uang</a></p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kode</th>
                        <th>Simbol</th>
                        <th>Nama</th>
                        <th>Default</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="currency in currencies">
                        <td class="text-nowrap">
                            <a href="javascript:void(0)" v-on:click="editItem" data-index="{{$index}}" data-toggle="modal" data-target="#currencyModal" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10" data-index="{{$index}}"></i></a> 
                            <a href="<?=$this->pathFor("accounting-currency-delete")?>{{currency.id}}" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a> 

                            <a href="<?=$this->pathFor("accounting-currency-rate")?>{{currency.id}}" data-toggle="tooltip" data-original-title="Kurs"> <i class="fa fa-bar-chart-o text-success m-r-10"></i> </a> 

                            
                        </td>
                        <td>{{currency.code}}</td>
                        <td>{{currency.symbol}}</td>
                        <td>{{currency.name}}</td>
                        <td>{{currency.defa}}</td>                        
                    </tr>
                </tbody>
            </table>

            <div id="currencyModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Form Mata Uang</h4>
                  </div>
                  <div class="modal-body">
                      <form class="form" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Kode</span></label>
                                    <div class="col-md-12">
                                        <input name="code" value="{{edit.code}}"  class="form-control">
                                        <input type="hidden" name="id" value="{{edit.id}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Simbol</span></label>
                                    <div class="col-md-12">
                                        <input name="symbol" value="{{edit.symbol}}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"> Nama</span></label>
                                    <div class="col-md-12">
                                        <input name="name" value="{{edit.name}}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-success">
                                            <input type="checkbox" value="1" name="defa" id="defa" v-model="edit.defa" />
                                            <label for="defa">Default</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success">
                                    Simpan</button>
                                </div>

                            </div>

                        </div>
                    </form>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            
        </div>
    </div>
</div>


<script type="text/javascript">
    window.currencies=<?=$currencies?>;
</script>

