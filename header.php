<div id="templatemo_header_wrapper">
	<div id="templatemo_header" class="wrapper">
		Copyright © 2013 <a href="#">Payroll Versi 1.0 </a> | Designed by <a href="#" target="_parent">IT PT. Lintech</a>
    	<div id="site_title"><a href="#">Lintech.co.id</a></div>		
        <div id="templatemo_menu" class="ddsmoothmenu">
            <ul>                
                <li><a href="#" class="<?php if ($_GET[sel]==1) echo "selected";?>">Master</a>
                    <ul>
                        <li><a href="m_periode.php">Periode</a></li>
                        <li><a href="m_employee.php">Employee</a></li>
						<li><a href="GajiPeriode.php">Gaji Periode</a></li>
						<li><a href="m_jabatan.php">Jabatan</a></li>	
						<li><a href="m_project.php">Project</a></li>
						<li><a href="m_lokasi.php">Lokasi Mesin</a></li>
						<li><a href="m_attribut.php">Setting Attribut</a></li>
						<li><a href="m_workshift.php">Workshift</a></li>
						<li><a href="m_group.php">Group Employee</a></li>
                  	</ul>
                </li>
				<li><a href="#" class = <?php if (isset($_GET['sel'])) { if ($_GET['sel']==2) echo "selected";} ?>>Kontrak</a>
					<ul>
                        <li><a href="contract.php">Kontrak Kerja</a></li>             
						<li><a href="contract_message.php">Message Kontrak</a></li>     												
					</ul>
				</li>
                <li><a href="#" class = <?php if (isset($_GET['sel'])) { if($_GET['sel']==3) echo "selected";}?>>Kasbon</a>
					<ul>
                        <li><a href="create_kasbon.php">Create Cashbon</a></li>                       
						<li><a href="cicilan_kasbon.php">Cicilan Kasbon</a></li>												
					</ul>
				</li>
					<li><a href="#" class = <?php if (isset($_GET['sel'])){ if ($_GET['sel']==4) echo "selected";}?>>[+] & [-]</a>
					<ul>
                        <li><a href="create_safetytalk.php">Potongan Safety Talk</a></li>
						<li><a href="create_plusmin.php">PlusMin Gaji</a></li>   
						<li><a href="periode_insentifjam.php">Insentif Jam Kerja</a></li>
  						<li><a href="periode_insentif_ium.php">Insentif Uang Makan</a></li>
					</ul>
				</li>
				<li><a href="#" class = <?php if (isset($_GET['sel'])){if ($_GET['sel']==5) echo "selected";}?>>Absen</a>
					<ul>
                        <li><a href="upload_file_absen.php">Upload CSV</a></li>
						<li><a href="insert_cuti.php">Ijin Khusus</a></li>
						<li><a href="periode_cekinout.php">Cek IN & OUT</a></li>
						<li><a href="./integrasi/index.php">Download Machine</a></li>
						<li><a href="delete_absen.php">Delete Absen</a></li>
						<li><a href="delete_absen.php">Delete Absen</a></li>  						
					</ul>
				</li>
								
				<li><a href="#" class = <?php if (isset($_GET['sel'])){if ($_GET['sel']==7) echo "selected";}?>>Report</a>
					<ul>
                        <li><a href="pilih_report.php">Payroll</a></li>
						<li><a href="m_pos.php">POS Payroll</a></li>
						<li><a href="report_potongan.php">Potongan</a></li>
					</ul>
				</li>
				<li><a href="x-change/" class = <?php if (isset($_GET['sel'])){if ($_GET['sel']==6) echo "selected";}?>>x-change</a>
				</li>
				<li><a href="logout.php" class = <?php if (isset($_GET['sel'])){if ($_GET['sel']==7) echo "selected";}?>>LogOut</a>					
				</li>
            </ul>
            <br style="clear: left" />
        </div> <!-- end of templatemo_menu -->
    </div>
</div>