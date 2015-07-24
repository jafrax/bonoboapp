<?php
echo "
<!-- Right side column. Contains the navbar and content of the page -->
            <aside class='right-side'>
                <!-- Content Header (Page header) -->
                <section class='content-header'>
                    <h1>
                        License Purchase
                    </h1>
                    <ol class='breadcrumb'>
                        <li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

                        <li class='active'>License Purchase</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class='content'>

                    <div class='box'>
                        <div class='box-header'>
                            <h3 class='box-title'></h3>                                    
                        </div><!-- /.box-header -->
                        <div class='box-body table-responsive'>
                            <div class='row'>
                                <div class='col-xs-12 col-md-6'>
                                <form id='form-generate' >
                                    <div class='row form-group'>
                                        <div class='col-xs-12'>
                                            <label>Pilih Toko</label>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-6'>
                                            <select class='chosen-select form-control' id='toko' name='toko'>
                                                <option value=''>Pilih Toko</option>";
                                                foreach ($toko->result() as $row_toko) {
                                                    echo "<option value='".$row_toko->id."'>".$row_toko->name."</option>";
                                                }
                                                echo "
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class='row form-group'>
                                        <div class='nolpadright col-xs-12'>
                                            <label>Durasi</label>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <input type='text' class='form-control numbersOnlyLicense' maxlength='2' id='duration' placeholder='15' name='duration'>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <select class='form-control' id='duration_type' name='duration_type' onchange=javascript:change_duration()>
                                                <option value=''>Pilih Tipe</option>
                                                <option value='d'>Hari</option>
                                                <option value='m'>Bulan</option>
                                                <option value='y'>Tahun</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row form-group'>
                                        <div class='nolpadright col-xs-12'>
                                            <label>Kode</label>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-6'>
                                            <input type='text' id='code' name='code' class='form-control' placeholder='xxxx-xxxx-xxxx-xxxx' value='' disabled>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-6'>
                                            <button type='button' class='btn btn-primary'>Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class='box-footer clearfix'>
                            
                        </div>
                    </div><!-- /.box -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

            ";
?>