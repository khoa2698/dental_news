<?php
class DB {

    private $hostname = 'localhost',
            $username = 'root',
            $password = '',
            $dbname = 'dentalnews';

    public $myConn = NULL;

    public function connect()
    {
       $this->myConn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
    }
    
    //Ham truy van
    public function query($qr = null) {
        if ($this->myConn) {
            $result = mysqli_query($this->myConn, $qr);
            return $result;
        }
    }

    // Count rows
    public function num_rows($qr = null)
    {
        if ($this->myConn) {
            $qrResult = mysqli_query($this->myConn, $qr);
            if ($qrResult) {
                $row = mysqli_num_rows($qrResult);
                return $row;
            }
        }
    }

    //get data
    public function fetch_assoc($qr = null, $type)
    {
        if($this->myConn) {
            $qrResult = mysqli_query($this->myConn, $qr);
            if($qrResult) {
                if($type == 1) {
                    // get many data to assign into array
                    while ($row = mysqli_fetch_assoc($qrResult)) {
                        $data[] = $row;
                    }
                }
                if($type == 0) {
                    // get 1 data row
                    $data = mysqli_fetch_assoc($qrResult);
                }
                return $data;
            }
        }
    }

    // get largest ID
    public function insert_ID()
    {
        if($this->myConn) {
            $count = mysqli_insert_id($this->myConn);
            if ($count == 0) {
                $count = "1";
            }
            else {
                $count = $count;
            }
            return $count;
        }
    }

    // Hàm charset cho database
    public function set_char($uni)
    {
        if ($this->myConn)
        {
            mysqli_set_charset($this->myConn, $uni);
        }
    }

    // Disconnect
    public function close()
    {
        if ($this->myConn)
            {
                mysqli_close($this->myConn);
        }
    }
}
?>