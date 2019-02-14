<?php 
class Machine {
    public $ip;
    public $port;

    public function __construct($ip, $port) {
            $this->ip = $ip;
            $this->port = $port;
    }

    public function connect() {

            try {
                    $connection = fsockopen($this->ip, $this->port, $errno, $errstr, 1);
                    return $connection;
            }
            catch (Exception $e){
                    echo 'Caught exception: ',  $e->getMessage(), "\n";			
            }

    }

    public function sendMessage($soap_message) {		
        $connection = $this->connect();

        if($connection) {
            $newLine="\r\n";
            fputs($connection, "POST /iWsService HTTP/1.0".$newLine);
            fputs($connection, "Content-Type: text/xml".$newLine);
            fputs($connection, "Content-Length: ".strlen($soap_message).$newLine.$newLine);
            fputs($connection, $soap_message.$newLine);

            $buffer="";
            while($response=fgets($connection, 1024)){
                    $buffer=$buffer.$response;
            }

            return $buffer;
        }

        return "";
    }
}

class Command {
    public $com;

    public function __construct($com) {
            $this->com = $com;
    }

    public function getAttLog() {
            $soap_message = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$this->com."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            return $soap_message;
    }

    public function getUserInfo($pin) {
            $soap_message = "<GetUserInfo><ArgComKey xsi:type=\"xsd:integer\">".$this->com."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">".$pin."</PIN></Arg></GetUserInfo>";
            return $soap_message;
    }

    public function getAllUserInfo() {
            $soap_message = "<GetUserInfo><ArgComKey xsi:type=\"xsd:integer\">".$this->com."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetUserInfo>";
            return $soap_message;
    }
}

class Downloader {
    public $machine;
    public $command;

    public function __construct($ip, $port, $com) {
            $this->machine = New Machine($ip, $port);
            $this->command = New Command($com);
    }

    public function getAttLog() {
             $response = $this->machine->sendMessage($this->command->getAttLog());
             return $this->array_formater($response);
    }

    public function getUserInfo($pin) {
            $response = $this->machine->sendMessage($this->command->getUserInfo($pin));
            return $this->array_formater($response);
    }
    public function getAllUserInfo() {
            $response = $this->machine->sendMessage($this->command->getAllUserInfo());
            return $this->array_formater($response);
    }

    public function array_formater($string) {
            $data = substr($string, strpos($string, "<"));
            $xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            return $array;
    }
}

class HkmLib 
{
    public function download($ip, $port, $com)
    {

            $client = New Downloader($ip, $port, $com);

            $x = $client->getAttLog();

            return $x;

    }
}

?>