<?php
 
echo"
    <div class='col s12 m12 l12'>
		<form id='formStep7' class='formain'>
			<div class='formhead'>
                <h2 class='titmain'><b>ATUR LEVEL HARGA</b></h2>
				<p>Anda bisa mendefinisikan nama untuk setiap level harga di toko Anda.</p>
			</div>
            <div class='row formbody nolmar'>
                <div class='linehead left-align'>
                    <b class='labelisasi'></b>
                </div>
                <div class='input-field col s12 m1 nolmar'>
                    <div class='col s12 m12 left-align'>
                        <p class='left nolpad'>
                            <input type='hidden' name='chkLevel1' value='".$Shop->level_1_active."' ".($Shop->level_1_active == 1 ? "checked" : "")." />
                            <input type='checkbox' id='chkLevel1' checked disabled/>
                            <label for='chkLevel1'></label>
                        </p>
                    </div>
                </div>
                <div class='input-field col s12 m11 nolmar'>
                    <h6 style='display:none;'>Level 1</h6>
                    <input name='txtLevel1' type='text' class='validate' value='".($Shop->level_1_name)."' autofocus placeholder='Level 1'>
                </div>
                
            </div>
            <div class='row formbody nolmar'>                                                     
                <div class='linehead nolmar'></div>
                    <div class='input-field col s12 m1 nolmar'>
                        <div class='col s12 m12 left-align'>
                            <p class='left nolpad'>
                                <input type='hidden' name='chkLevel2' value='".$Shop->level_2_active."' ".($Shop->level_2_active == 1 ? "checked" : "")."/>
                                <input type='checkbox' id='chkLevel2' ".($Shop->level_2_active == 1 ? "checked" : "")."  ".($status2 == 1 ? "disabled" : "")." onclik='javascript:on_change()' />
                                <label for='chkLevel2'></label>
                            </p>
                        </div>
                    </div>
                    <div class='input-field col s12 m11 nolmar'>
                        <h6 style='display:none;'>Level 2</h6>
                        <input name='txtLevel22' type='text' class='validate' value='".($Shop->level_2_name)."' ".($Shop->level_2_active == 0 ? "disabled" : "")." placeholder='Level 2' >
                        <input id='txtLevel2' name='txtLevel2' type='hidden' class='validate' value='".($Shop->level_2_name)."' placeholder='Level 2' >
                        <label id='labelLevel2' for='chkLevel2' ".($status2 == 0 ? "hidden" : "").">Level Harga sedang digunakan</label>
                    </div>
                </div>
                <div class='row formbody nolmar'>                                                     
                    <div class='linehead'></div>
                        <div class='input-field col s12 m1 nolmar'>
                            <div class='col s12 m12 left-align'>
                                <p class='left nolpad'>
                                    <input type='hidden' name='chkLevel3' value='".$Shop->level_3_active."' ".($Shop->level_3_active == 1 ? "checked" : "")." />
                                    <input type='checkbox' id='chkLevel3' ".($Shop->level_3_active == 1 ? "checked" : "")."  ".($status3 == 1 ? "disabled" : "")." onclik='javascript:on_change()' />                
                                    <label for='chkLevel3'></label>
                                </p>
                            </div>
                        </div>
                        <div class='input-field col s12 m11 nolmar'>
                            <h6 style='display:none;'>Level 3</h6>
                            <input name='txtLevel33' type='text' class='validate' value='".$Shop->level_3_name."' ".($Shop->level_3_active == 0 ? "disabled" : "")." placeholder='Level 3'>
                            <input id='txtLevel3' name='txtLevel3' type='hidden' class='validate' value='".($Shop->level_3_name)."' placeholder='Level 3' >
                            <label id='labelLevel3' for='chkLevel3' ".($status3 == 0 ? "hidden" : "").">Level Harga sedang digunakan</label>
                        </div>
                    </div>
                    <div class='row formbody nolmar'>                                                     
                        <div class='linehead'></div>
                            <div class='input-field col s12 m1 nolmar'>
                                <div class='col s12 m12 left-align '>
                                    <p class='left nolpad'>
                                        <input type='hidden' name='chkLevel4' value='".$Shop->level_4_active."' ".($Shop->level_4_active == 1 ? "checked" : "")." />
                                        <input type='checkbox' id='chkLevel4' ".($Shop->level_4_active == 1 ? "checked" : "")."  ".($status4 == 1 ? "disabled" : "")." onclik='javascript:on_change()' />
                                        <label for='chkLevel4'></label>
                                    </p>
                                </div>
                            </div>
                            <div class='input-field col s12 m11 nolmar'>
                                <h6 style='display:none;'>Level 4</h6>
                                <input name='txtLevel44' type='text' class='validate' value='".$Shop->level_4_name."' ".($Shop->level_4_active == 0 ? "disabled" : "")." placeholder='Level 4'>
                                <input id='txtLevel4' name='txtLevel4' type='hidden' class='validate' value='".($Shop->level_4_name)."' placeholder='Level 4' >
                                <label id='labelLevel4' for='chkLevel4' ".($status4 == 0 ? "hidden" : "").">Level Harga sedang digunakan</label>
                            </div>
                        </div>
                        <div class='row formbody'>                                                     
                        <div class='linehead'></div>
                        <div class='input-field col s12 m1'>
                            <div class='col s12 m12 left-align'>
                                <p class='left nolpad'>
                                    <input type='hidden' name='chkLevel5' value='".$Shop->level_5_active."' ".($Shop->level_5_active == 1 ? "checked" : "")." />
                                    <input type='checkbox' id='chkLevel5' ".($Shop->level_5_active == 1 ? "checked" : "")."  ".($status5 == 1 ? "disabled" : "")." onclik='javascript:on_change()' />
                                    <label for='chkLevel5'></label>
                                </p>
                            </div>
                        </div>
                        <div class='input-field col s12 m11'>
                            <h6 style='display:none;'>Level 5</h6>
                            <input name='txtLevel55' type='text' class='validate' value='".($Shop->level_5_name)."' ".($Shop->level_5_active == 0 ? "disabled" : "")." placeholder='Level 5'>
                            <input id='txtLevel5' name='txtLevel5' type='hidden' class='validate' value='".($Shop->level_5_name)."' placeholder='Level 5' >
                            <label id='labelLevel5' for='chkLevel5' ".($status5 == 0 ? "hidden" : "").">Level Harga sedang digunakan</label>
                        </div>
                     </div>
                <div class='row formbody'>
                    <a href='".base_url("toko/step4")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a>
                    <button id='btnSave' class='btn waves-effect waves-light' type='button'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>
                    <label id='notifStep7' style='display:none;'></label>
                </div>
            </form>
        </div>
       
        <script>
                var ctrlShopStep5 = new CtrlShopStep5();
                ctrlShopStep5.init();
        </script>
";
 
?>