<?php
echo "
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
								if ($this->uri->segment(4)!= ''){
									$i = $this->uri->segment(4);
								}
                                foreach ($license->result() as $row) {
                                    echo "<tr>
                                                <td>$i</td>
                                                <td>".$row->email."</td>
                                                <td>".$row->code."</td>
                                                <td>".($row->validity == 1 ? "Kode belum diinput" : "Kode sudah dipakai")."</td>
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
";
?>