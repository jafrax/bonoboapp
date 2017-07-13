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
                        <li><a href='".site_url('admin/index/dashboard')."'><i class='fa fa-dashboard'></i> Dashboard</a></li>

                        <li class='active'>License Purchase</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class='content'>

                    <div class='box'>
                        <div class='box-header'>
                            <h3 class='box-title'></h3>                                    
                        </div><!-- /.box-header -->
                        <div id='notif'></div>
                        <div class='box-body table-responsive'>
                        ";
                        //Inisialisasi

                        $val_auto_add       =   $this->model_license->get_config($this->config->item('default_auto_add_license'))->row();
                        $val_code           =   $this->model_license->get_config($this->config->item('default_code'))->row();
                        $val_duration_type  =   $this->model_license->get_config($this->config->item('default_duration_type'))->row();
                        $val_duration       =   $this->model_license->get_config($this->config->item('default_duration'))->row();

                        $auto_add       = 0;
                        $code           = "---";
                        $duration_type  = "";
                        $duration       = "";
                        if (count($val_auto_add))        {$auto_add      = $val_auto_add->value;}
                        if (count($val_code))            {$code          = $val_code->value;}
                        if (count($val_duration_type))   {$duration_type = $val_duration_type->value;}
                        if (count($val_duration))        {$duration      = $val_duration->value;}

                        $arr_code = explode('-', $code);


                        echo"
                        <form id='form-setting'>
                            <div class='box-tools'>
                                <div class='input-group'>
                                    <label>
                                        <input type='checkbox' name='".$this->config->item('default_auto_add_license')."' id='auto_add' class='flat-red' ".($auto_add == 1 ? "checked" : "")."/>
                                        Auto add license on Registration
                                    </label>
                                </div>
                            </div><br>

                            <div class='row'>
                                <div class='col-xs-12 col-md-6'> 
                                    <div class='row form-group'>
                                        <div class='col-xs-12'>
                                            <label>Default Code</label> 
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <input type='text' class='form-control numbersOnly' name='code_1' maxlength='4' size='4' placeholder='xxxx' value='".($arr_code[0] != '' ? $arr_code[0] : "")."'/>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <input type='text' class='form-control numbersOnly' name='code_2' maxlength='4' size='4' placeholder='xxxx' value='".($arr_code[1] != '' ? $arr_code[1] : "")."'/>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <input type='text' class='form-control numbersOnly' name='code_3' maxlength='4' size='4' placeholder='xxxx' value='".($arr_code[2] != '' ? $arr_code[2] : "")."'/>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <input type='text' class='form-control numbersOnly' name='code_4' maxlength='4' size='4' placeholder='xxxx' value='".($arr_code[3] != '' ? $arr_code[3] : "")."'/>
                                        </div>
                                    </div>
                                    <div class='row form-group'>
                                        <div class='nolpadright col-xs-12'>
                                            <label>Length</label>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <input type='text' class='form-control numbersOnlyLicense' maxlength='2' id='duration' placeholder='15' name='".$this->config->item('default_duration')."' value='".($duration != "" ? $duration  : "")."'>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <select class='form-control' id='duration_type' name='".$this->config->item('default_duration_type')."'  onchange=javascript:change_duration()>
                                                <option value=''>Pilih Durasi</option>
                                                <option ".($duration_type == 'd' ? "selected" : "")." value='d'>Hari</option>
                                                <option ".($duration_type == 'm' ? "selected" : "")." value='m'>Bulan</option>
                                                <option ".($duration_type == 'y' ? "selected" : "")." value='y'>Tahun</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div><!-- /.box-body -->
                        <div class='box-footer clearfix'>
                            <button type='button' onclick=javascript:submit_setting() id='btn-submit-setting' class='btn btn-primary'>Simpan</button>                            
                        </div>
                    </div><!-- /.box -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->";

            ?>