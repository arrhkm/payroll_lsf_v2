<?php 
class TarifMasakerja{
    public $link;
    public $sql;
    function __construct($link)
    {
        $this->link = $link;
        $this->sql= "SELECT * FROM  tarif_tunjangan_masakerja";
        
    }

    public function getMaxMasakerja(){
        $rs = mysqli_query($this->link, $this->sql);

        $tarif = [];
        while ($row = mysqli_fetch_array($rs)){
            array_push($tarif, [
                'masa_kerja'=>$row['masa_kerja'],
                'nilai'=>$row['nilai_tunjangan'],
            ]);
        }      
               
        $max = max($tarif);
        return $max['nilai'];

    }

    public function getListTarif(){
        $rs = mysqli_query($this->link, $this->sql);

        $tarif = [];
        while ($row = mysqli_fetch_array($rs)){
            array_push($tarif, [
                'masa_kerja'=>$row['masa_kerja'],
                'nilai'=>$row['nilai_tunjangan'],
            ]);
        }      
               
        
        return $tarif;

    }
}

?>