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
                            <div class='box-tools'>
                                <div class='row form-group'>
                                    <div class='padbottom col-xs-12 col-md-4'>
                                        <select class=' form-control' id='option' onchange=javascript:change_option()>
                                            <option value='3' >Pilih Status</option>
                                            <option value='1' ".($_SESSION['option'] == 1 ? "selected" : "").">Kode belum diinput</option>
                                            <option value='2' ".($_SESSION['option'] == 2 ? 'selected' : '').">Menunggu Kode</option>
                                            <option value='0' ".($_SESSION['option'] == 0 ? 'selected' : '').">Kode sudah digunakan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='input-group'>
                                    <input type='text' id='search' name='table_search' onchange=javascript:search('#search','admin/license/search') class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search'/>
                                    <div class='input-group-btn'>
                                        <button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/license/search')><i class='fa fa-search'></i></button>
                                    </div>
                                </div>
                            </div><br>
                            <div id='div-paging'>
                            <table class='table table-bordered table-striped'>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Toko</th>
                                        <th>Kode Verifikasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>";
                                $i=1;
                                foreach ($license->result() as $row) {
                                    echo "<tr>
                                                <td>$i</td>
                                                <td>".$row->email."</td>
                                                <td>".$row->code."</td>
                                                <td>";if ($row->validity == 1) {
                                                    echo "Kode belum diinput";
                                                }elseif ($row->validity == 0) {
                                                    echo "Kode sudah dipakai";
                                                }elseif ($row->validity == 2) {
                                                    echo "Menunggu Kode";
                                                } 
                                                echo"</td>
                                            </tr>";
                                            $i++;
                                }echo "
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Toko</th>
                                        <th>Kode Verifikasi</th>
                                        <th>Status</th>
                                </tfoot>
                            </table>
                            <div class='box-footer clearfix'>
                                <ul class='pagination pagination-sm no-margin pull-right'>
                                    $pagination
                                </ul>
                            </div>
                            </div>                        
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->";
            ?>