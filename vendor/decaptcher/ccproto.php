<?php
require 'api.php';

define('CC_PROTO_VER', 1); // protocol version
define('CC_RAND_SIZE', 256); // size of the random sequence for authentication procedure
define('CC_MAX_TEXT_SIZE', 100); // maximum characters in returned text for picture
define('CC_MAX_LOGIN_SIZE', 100); // maximum characters in login string
define('CC_MAX_PICTURE_SIZE', 200000); // 200 K bytes for picture seems sufficient for all purposes
define('CC_HASH_SIZE', 32);

define('CC_CMD_UNUSED', 0);
define('CC_CMD_LOGIN', 1); // login
define('CC_CMD_BYE', 2); // end of session
define('CC_CMD_RAND', 3); // random data for making hash with login+password
define('CC_CMD_HASH', 4); // hash data
define('CC_CMD_PICTURE', 5); // picture data, deprecated
define('CC_CMD_TEXT', 6); // text data, deprecated
define('CC_CMD_OK', 7); //
define('CC_CMD_FAILED', 8); //
define('CC_CMD_OVERLOAD', 9); //
define('CC_CMD_BALANCE', 10); // zero balance
define('CC_CMD_TIMEOUT', 11); // time out occured
define('CC_CMD_PICTURE2', 12); // picture data
define('CC_CMD_PICTUREFL', 13); // picture failure
define('CC_CMD_TEXT2', 14); // text data
define('CC_CMD_SYSTEM_LOAD', 15); // system load
define('CC_CMD_BALANCE_TRANSFER', 16); // zero balance

define('CC_SIZEOF_PACKET', 6);
define('CC_SIZEOF_PICT_DESCR', 20);
define('CC_SIZEOF_BALANCE_TRANSFER_DESC', 8);

define('CC_I_MAGIC', 268435455);
define('CC_Q_MAGIC', 268435440);

/**
 * packet class
 */
class cc_packet {
    private $ver = CC_PROTO_VER; // version of the protocol
    private $cmd = CC_CMD_BYE; // command, see cc_cmd_t
    private $size = 0; // data size in consequent bytes 
    private $data = ''; // packet payload

    private function checkPackHdr($cmd = null, $size = null) {
        if ($this->ver !== CC_PROTO_VER) {
           return false;
        }
        
        if (isset($cmd) && ($this->cmd !== $cmd)) {
           return false;
        }
        
        if (isset($size) && ($this->size !== $size)) {
           return false;
        }

        return true;
    }

    public function pack() {
        return pack('CCV', $this->ver, $this->cmd, $this->size) . $this->data;
    }

    public function packTo($handle) {
        return fwrite($handle, $this->pack(), CC_SIZEOF_PACKET + strlen($this->data));
    }

    private function unpackHeader($bin) {
        $arr = unpack('Cver/Ccmd/Vsize', $bin);
        $this->ver = $arr['ver'];
        $this->cmd = $arr['cmd'];
        $this->size = $arr['size'];
    }

    public function unpackFrom($handle, $cmd = null, $size = null) {
        $bin = stream_get_contents($handle, CC_SIZEOF_PACKET);
        
        if ($bin === false) {
            return false;
        }

        if (strlen($bin) < CC_SIZEOF_PACKET) {
            return false;
        }

        $this->unpackHeader($bin);

        if ($this->checkPackHdr($cmd, $size) === false) {
            return false;
        }

        if ($this->size > 0) {
            $bin = stream_get_contents($handle, $this->size);
            
            if ($bin === false) {
                return false;
            }
            
            $this->data = $bin;
        }
        else {
            $this->data = '';
        }

        return true;
    }

    public function setVer($ver) {
        $this->ver = $ver;
    }

    public function getVer() {
        return $this->ver;
    }

    public function setCmd($cmd) {
        $this->cmd = $cmd;
    }

    public function getCmd() {
        return $this->cmd;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function calcSize() {
        return $this->size = strlen($this->data);
    }

    public function getFullSize() {
        return CC_SIZEOF_PACKET + $this->size;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }
}

/*
**
* picture description class
*/
class cc_pict_descr {
    private $timeout = CC_PTO_DEFAULT;
    private $type = CC_PT_UNSPECIFIED;
    private $size = 0;
    private $major_id = 0;
    private $minor_id = 0;
    private $data = '';

    public function pack() {
        return pack('VVVVV', $this->timeout, $this->type, $this->size, $this->major_id, $this->minor_id) . $this->data;
    }

    public function unpack($bin) {
        $arr = unpack('Vtimeout/Vtype/Vsize/Vmajor_id/Vminor_id', $bin);
        $this->timeout = $arr['timeout'];
        $this->type = $arr['type'];
        $this->size = $arr['size'];
        $this->major_id = $arr['major_id'];
        $this->minor_id = $arr['minor_id'];
        
        if (strlen($bin) > CC_SIZEOF_PICT_DESCR) {
            $this->data = substr($bin, CC_SIZEOF_PICT_DESCR);
        }
        else {
            $this->data = '';
        }
    }

    public function setTimeout($to) {
        $this->timeout = $to;
    }

    public function getTimeout() {
        return $this->timeout;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function calcSize() {
        return $this->size = strlen($this->data);
    }

    public function getFullSize() {
        return CC_SIZEOF_PICT_DESCR + $this->size;
    }

    public function setMajorID($major_id) {
        $this->major_id = $major_id;
    }

    public function getMajorID() {
        return $this->major_id;
    }

    public function setMinorID($minor_id) {
        $this->minor_id = $minor_id;
    }

    public function getMinorID() {
        return $this->minor_id;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }
}

/*
**
* balance transfer description class
*/
class cc_balance_transfer_descr {
    private $sum = 0;
    private $to_length = 0;
    private $to = '';

    public function pack() {
        return pack('VV', $this->sum, $this->to_length) . $this->to;
    }

    public function unpack($bin) {
        $arr = unpack('Vsum/Vto_length', $bin);
        $this->sum = $arr['sum'];
        $this->to_length = $arr['to_length'];
        
        if (strlen($bin) > CC_SIZEOF_BALANCE_TRANSFER_DESC) {
            $this->to = substr($bin, CC_SIZEOF_BALANCE_TRANSFER_DESC);
        } else {
            $this->to = '';
        }
    }

    public function setSum($sum) {
        $this->sum = $sum;
    }

    public function getSum() {
        return $this->sum;
    }

    public function setTo($to) {
        $this->to = $to;
    }

    public function getTo() {
        return $this->to;
    }

    public function calcSize() {
        return $this->to_length = strlen($this->to);;
    }

    public function getFullSize() {
        return CC_SIZEOF_BALANCE_TRANSFER_DESC + $this->to_length;
    }
}
