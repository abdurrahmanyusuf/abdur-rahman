<?php 
include "koneksi.php";
             $id=$_GET['id'];
             $tampil = mysql_query("SELECT * FROM tb_pelanggan WHERE id_pelanggan='$id'");
             $data = mysql_fetch_array($tampil);
 if (isset($_POST['simpan'])) {
     $id_pelanggan=$_POST['id_pelanggan'];
     $id_tagihan=$_POST['id_tagihan'];
     $nama_pelanggan=$_POST['nama_pelanggan'];
     $area=$_POST['area'];
     $tarif_listrik=$_POST['tarif_listrik'];
     $tarif_air=$_POST['tarif_air'];
     $bulan_tahun=$_POST['bulan_tahun'];
     $meter_bulan_lalu=$_POST['meter_bulan_lalu'];
     $meter_bulan_sekarang=$_POST['meter_bulan_sekarang'];
     $total_pemakaian= $meter_bulan_sekarang - $meter_bulan_lalu ;
     $jumlah_tagihan_listrik=$total_pemakaian * $tarif_listrik;
     $meter_bulan_lalu_air=$_POST['meter_bulan_lalu_air'];
     $meter_bulan_sekarang_air=$_POST['meter_bulan_sekarang_air'];
     $total_pemakaian_air=$meter_bulan_sekarang_air - $meter_bulan_lalu_air;
     $jumlah_tagihan_air=$total_pemakaian_air * $tarif_air;
     $total_tagihan=$jumlah_tagihan_listrik + $jumlah_tagihan_air;     
     
 
    $cek=mysql_num_rows(mysql_query("select * from tb_tagihan where id_pelanggan='$id_pelanggan'"));

    $cek1=mysql_num_rows(mysql_query("select * from tb_tagihan where meter_bulan_lalu='$meter_bulan_lalu'"));    
    $cek2=mysql_num_rows(mysql_query("select * from tb_tagihan where meter_bulan_sekarang='$meter_bulan_sekarang'"));

    if ($cek1 < $cek2) {
        echo "<script>alert('meter yang anda inputkan masih kurang');</script>";
    }else{
         $insert=mysql_query("insert into tb_tagihan(
                                              id_pelanggan,
                                              id_tagihan,
                                              nama_pelanggan,
                                              id_area,
                                              tarif_listrik,
                                              tarif_air,
                                              bulan_tahun,
                                              meter_bulan_lalu,
                                              meter_bulan_sekarang,
                                              total_pemakaian,
                                              jumlah_tagihan_listrik,
                                              meter_bulan_lalu_air,
                                              meter_bulan_sekarang_air,
                                              total_pemakaian_air,
                                              jumlah_tagihan_air,
                                              total_tagihan
                                              )
                                             values(
                                                     '$id_pelanggan',
                                                     '$id_tagihan',
                                                     '$nama_pelanggan',
                                                     '$area',
                                                     '$tarif_listrik',
                                                     '$tarif_air',
                                                     '$bulan_tahun',
                                                     '$meter_bulan_lalu',
                                                     '$meter_bulan_sekarang',
                                                     '$total_pemakaian',
                                                     '$jumlah_tagihan_listrik',
                                                     '$meter_bulan_lalu_air',
                                                     '$meter_bulan_sekarang_air',
                                                     '$total_pemakaian_air',
                                                     '$jumlah_tagihan_air',
                                                     '$total_tagihan')") or die(mysql_error());
         if ($insert) {
             echo "<script>alert('data sudah disimpan');</script>";
         }else
         {
             echo "<script>alert('maaf data gagal disimpan');</script>";
         }
     }
     echo '<meta http-equiv="refresh"  content="0; index.php?page=transaksi/tagihan/input_tagihan" >'; 
 }
 
//kode otomatis untuk user
$query = "select max(id_tagihan)as maxkode from tb_tagihan";
$hasil = mysql_query($query);
$cek = mysql_fetch_array($hasil);
$id_tagihan = $cek['maxkode'];
$nourut = (int) substr($id_tagihan,2,3);
$nourut ++;
$char = "KT";
$newid = $char.sprintf("%03s",$nourut);
?>
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form class="form-horizontal" method="POST">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><a href="index.php?page=transaksi/tagihan/view_tagihan"><button type="button" class="btn btn-info">  Kembali</button><strong>Input Tagihan</strong> Pelanggan</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <?php 
                                            if (isset($_GET['id'])){
                                                include('koneksi.php');
                                                $id = $_GET['id'];
                                                $sql = mysql_query("SELECT j.id_pelanggan, j.nama_pelanggan, j.meter_listrik, j.meter_air, p.id_area, p.nama_area, p.tarif_listrik, p.tarif_air
                                                    FROM  tb_pelanggan as j, tb_area as p  where j.id_area = p.id_area and j.id_pelanggan='$id' ") or die (mysql_error());
                                                $data_plg = mysql_fetch_array($sql);
                                                $nm   = $data_plg['nama_pelanggan'];
                                                $kd   = $data_plg['id_pelanggan'];
                                                $ml   = $data_plg['meter_listrik'];
                                                $ma   = $data_plg['meter_air'];
                                                $na   = $data_plg['nama_area'];
                                                $tl   = $data_plg['tarif_listrik'];
                                                $ta   = $data_plg['tarif_air'];
                                             } 

                                         ?>

                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Kode Tagihan</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" name="id_tagihan" value="<?php echo "$newid"; ?>" class="form-control" readonly="readonly"/>
                                                    </div>                                            
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Kode Pelanggan</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" class="form-control" value="<?php echo $kd; ?>" name="id_pelanggan" readonly="readonly"  />
                                                        <span class="input-group-addon"  data-toggle="modal" data-target="#myModal"><span class="fa fa-search" ></span></span></a>
                                                    </div>   
                                                    <span class="help-block">Silahkan Klik Tombol Cari</span>                                                                                             
                                                </div>
                                            </div>
<!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                    <center><h4 class="modal-title">Pilih Nama Pelanggan</h4></center>
                </div>
                <div class="modal-body">
                <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-body">
                <?php
                include "koneksi.php";
                $query = mysql_query("SElECT * FROM tb_pelanggan"); ?>
                                    <table class="table datatable">
                        <thead>
                      <tr class='btn-inverse'>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Action</th>
                      </tr>
                    </thead>
  
                    <tbody>
                          <?
                            $no=0;  
                            while ($r = mysql_fetch_array($query)) {
                            $no++; 
                          ?>
                        <tr>
                            <td><? echo $no; ?></td>
                            <td><? echo $r['nama_pelanggan'];?></td>
                            <td><? echo $r['alamat_pelanggan'];?></td>
                            <td><? echo $r['no_telp'];?></td>
                                                <td align="center">
                                                <button type="button" class="btn btn-info btn-rounded"><a href="index.php?page=transaksi/tagihan/input_tagihan&id=<?php echo $r['id_pelanggan']; ?>">Tagih</button>
                                                </td>
                                            </tr>
                                            <? } ?>   
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                            <!-- END DEFAULT DATATABLE -->
                </div>
                </div>                                
                    
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!--end modal-->                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Nama Pelanggan</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" class="form-control" value=" <?php echo $nm; ?> " name="nama_pelanggan" readonly="readonly"/>
                                                    </div>                                            
                                                </div>
                                            </div>

                                    <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Area</label>
                                            <div class="col-md-6 col-xs-12">
                                                <select class="form-control select" name="area" id="area" >
                                                    <option value="">-Pilih-</option>
                                                        <?php
                                                            include"koneksi.php";
                                                            $querypp=mysql_query("SELECT * from tb_area order by nama_area desc");
                                                            while ($rowpp=mysql_fetch_array($querypp)) {
                                                         ?>
                                                            <option value="<?php echo $rowpp['id_area'];?>"><?php echo $rowpp['nama_area']; ?></option>
                                                            <?php  
                                                            }
                                                            ?>
                                                  </select>
                                            </div>
                                    </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Tarif Listrik</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" id="txt5" onkeyup="kurangi()" class="form-control" value=" <?php echo $tl; ?> " name="tarif_listrik" readonly="readonly"/>
                                                    </div>                                            
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Tarif Air</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" class="form-control" id="txt9" onkeyup="kali()" value=" <?php echo $ta; ?> " name="tarif_air" readonly="readonly"/>
                                                    </div>                                            
                                                </div>
                                            </div>
                                                                                    
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">Tanggal</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        <input type="text" class="form-control" value="<?php echo "" . date("Y-m-d");?>" name="bulan_tahun" readonly="readonly">                                            
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>

                                        <div class="col-md-6">

                                            <span><h4><center>TAGIHAN LISTRIK</center></h4></span>                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Meter Bulan Lalu</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" class="form-control" name="meter_bulan_lalu" id="txt4" value=" <?php echo $ml; ?> " readonly="readonly"/>
                                                    </div>                                            
                                                </div>
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Meter Bulan Sekarang</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" id="txt3" name="meter_bulan_sekarang" name="meter_bulan_sekarang" class="form-control"/>
                                                    </div>                                            
                                                </div>
                                            </div>

                                            <span><h4><center>TAGIHAN AIR</center></h4></span>                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Meter Bulan Lalu</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" class="form-control" name="meter_bulan_lalu_air" onkeyup="kali()" id="txt8" value=" <?php echo $ma; ?> " readonly="readonly"/>
                                                    </div>                                            
                                                </div>
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Meter Bulan Sekarang</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil" ></span></span>
                                                        <input type="text" id="txt7" onkeyup="kali()" name="meter_bulan_sekarang_air" class="form-control"/>
                                                    </div>                                            
                                                </div>
                                            </div>                                                                                                                                
                                        </div>
                                        
                                    </div>

                                </div>
                                            <script type="text/javascript">
                                                <?php echo $jsArray; ?>
                                                function changeValue(ia){
                                                    document.getElementById('tarif').value = name[ia].tarif;
                                                };
                                            </script> 
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" type="submit" value="simpan" name="simpan">Simpan Data <span class="fa fa-floppy-o fa-right"></span></button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>              
<!-- inline scripts related to this page -->
        <!--<script type="text/javascript">
            
            function kurangi() {
                var txtFirstNumberValue = document.getElementById('txt3').value;
                var txtSecondNumberValue = document.getElementById('txt4').value;
                var txtTigaNumberValue = document.getElementById('txt5').value;
                var result = parseInt(txtFirstNumberValue)-parseInt(txtSecondNumberValue);
                var result2 = parseInt(result)*parseInt(txtTigaNumberValue);
                  if (!isNaN(result2)) {
                     document.getElementById('txt6').value = result2;
                  }
            }
            function kali(){      
                var txtFirstNumberValue1 = document.getElementById('txt7').value;
                var txtSecondNumberValue1 = document.getElementById('txt8').value;
                var txtTigaNumberValue1 = document.getElementById('txt9').value;
                var result3 = parseInt(txtFirstNumberValue1)-parseInt(txtSecondNumberValue1);
                var result4 = parseInt(result3)*parseInt(txtTigaNumberValue1);
                  if (!isNaN(result4)) {
                     document.getElementById('txt10').value = result4;
                  }

            }
            function tambah(){      
                var txtFirstNumberValue1 = document.getElementById('txt6').value;
                var txtSecondNumberValue1 = document.getElementById('txt10').value;
                var result5 = parseInt(txtFirstNumberValue1)+parseInt(txtSecondNumberValue1);
                  if (!isNaN(result5)) {
                     document.getElementById('txt13').value = result5;
                  }

            }

            function tambah1(){      
                var txtFirstNumberValue2 = document.getElementById('txt3').value;
                var txtSecondNumberValue2 = document.getElementById('txt4').value;
                var result6 = parseInt(txtFirstNumberValue2)-parseInt(txtSecondNumberValue2);
                  if (!isNaN(result6)) {
                     document.getElementById('txt14').value = result6;
                  }

            } 

            function tambah2(){      
                var txtFirstNumberValue3 = document.getElementById('txt7').value;
                var txtSecondNumberValue3 = document.getElementById('txt8').value;
                var result7 = parseInt(txtFirstNumberValue3)-parseInt(txtSecondNumberValue3);
                  if (!isNaN(result7)) {
                     document.getElementById('txt15').value = result7;
                  }

            }          

            </script> -->