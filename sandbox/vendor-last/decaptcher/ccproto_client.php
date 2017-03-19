<?php
define('CC_ERR_OK', 0); // everything went OK
define('CC_ERR_GENERAL', -1); // general internal error
define('CC_ERR_STATUS', -2); // status is not correct
define('CC_ERR_NET_ERROR', -3); // network data transfer error
define('CC_ERR_TEXT_SIZE', -4); // text is not of an appropriate size
define('CC_ERR_OVERLOAD', -5); // server's overloaded
define('CC_ERR_BALANCE', -6); // not enough funds to complete the request
define('CC_ERR_TIMEOUT', -7); // request timed out
define('CC_ERR_BAD_PARAMS', -8); // provided parameters are not good for this function
define('CC_ERR_UNKNOWN', -200); // unknown error

// picture processing TIMEOUTS
define('CC_PTO_DEFAULT', 0); // default timeout, server-specific
define('CC_PTO_LONG', 1); // long timeout for picture, server-specfic
define('CC_PTO_30SEC', 2); // 30 seconds timeout for picture
define('CC_PTO_60SEC', 3); // 60 seconds timeout for picture
define('CC_PTO_90SEC', 4); // 90 seconds timeout for picture

// picture processing TYPES
define('CC_PT_UNSPECIFIED', 0); // unspecified
define('CC_PT_ASIRRA', 86); // ASIRRA pictures
define('CC_PT_TEXT', 83); // TEXT questions
define('CC_PT_MULTIPART', 82); // MULTIPART quetions

// multi-picture processing specifics
define('CC_PT_ASIRRA_PICS_NUM', 12);
define('CC_PT_MULTIPART_PICS_NUM', 20);


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


ini_set('max_execution_time', 0);

define('sCCC_INIT', 1); // initial status, ready to issue LOGIN on client
define('sCCC_LOGIN', 2); // LOGIN is sent, waiting for RAND (login accepted) or CLOSE CONNECTION (login is unknown) 
define('sCCC_HASH', 3); // HASH is sent, server may CLOSE CONNECTION (hash is not recognized)
define('sCCC_PICTURE', 4);

/**
 * CC protocol class
 */
class ccproto {
    private $status;
    private $s;
    private $context;

    function init() {
        $this->status = sCCC_INIT;
    } // init()

    function login($hostname, $port, $login, $pwd, $ssl = false) {
        $this->status = sCCC_INIT;

        $errnum = 0;
        $errstr = '';
        $transport = 'tcp';

        $this->context = stream_context_create();
        
        if ($ssl) {
            $transport = 'ssl';
            $result = stream_context_set_option($this->context, 'ssl', 'allow_self_signed', true);
        }

        $this->s = @stream_socket_client($transport . '://' . $hostname . ':' . $port, $errnum, $errstr, ini_get('default_socket_timeout') , STREAM_CLIENT_CONNECT, $this->context);
        
        if ($this->s === false) {
            echo 'We have a stream_socket_client() error: ', $errstr, ' (', $errnum, ')' , PHP_EOL;
            return CC_ERR_NET_ERROR;
        }

        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_LOGIN);
        $pack->setSize(strlen($login));
        $pack->setData($login);

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s, CC_CMD_RAND, CC_RAND_SIZE) === false) {
            return CC_ERR_NET_ERROR;
        }

        $shabuf = null;
        $shabuf .= $pack->getData();
        $shabuf .= md5($pwd);
        $shabuf .= $login;

        $pack->setCmd(CC_CMD_HASH);
        $pack->setSize(CC_HASH_SIZE);
        $pack->setData(hash('sha256', $shabuf, true));

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s, CC_CMD_OK) === false) {
            return CC_ERR_NET_ERROR;
        }

        $this->status = sCCC_PICTURE;

        return CC_ERR_OK;
    } // login()

    function picture2(
        $pict, // IN picture binary data
        &$pict_to, // IN/OUT timeout specifier to be used, on return - really used specifier, see CC_PTO_XXX constants, CC_PTO_DEFAULT in case of unrecognizable
        &$pict_type, // IN/OUT type specifier to be used, on return - really used specifier, see CC_PT_XXX constants, CC_PT_UNSPECIFIED in case of unrecognizable
        &$text, // OUT text
        &$major_id = null, // OUT OPTIONAL major part of the picture ID
        &$minor_id = null // OUT OPTIONAL minor part of the picture ID
    ) {
        if ($this->status !== sCCC_PICTURE) {
            return CC_ERR_STATUS;
        }

        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_PICTURE2);

        $desc = new cc_pict_descr();
        $desc->setTimeout(CC_PTO_DEFAULT);
        $desc->setType($pict_type);
        $desc->setMajorID(0);
        $desc->setMinorID(0);
        $desc->setData($pict);
        $desc->calcSize();
        $pack->setData($desc->pack());
        $pack->calcSize();

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        switch($pack->getCmd()) {
            case CC_CMD_TEXT2:
                $desc->unpack($pack->getData());
                $pict_to = $desc->getTimeout();
                $pict_type = $desc->getType();
                $text = $desc->getData();

                if (isset($major_id)) {
                    $major_id = $desc->getMajorID();
                }
                
                if (isset($minor_id)) {
                    $minor_id = $desc->getMinorID();
                }
                
                return CC_ERR_OK;

            case CC_CMD_BALANCE:
                // balance depleted
                return CC_ERR_BALANCE;

            case CC_CMD_OVERLOAD:
                // server's busy
                return CC_ERR_OVERLOAD;

            case CC_CMD_TIMEOUT:
                // picture timed out
                return CC_ERR_TIMEOUT;

            case CC_CMD_FAILED:
                // server's error
                return CC_ERR_GENERAL;

            default:
                // unknown error
                return CC_ERR_UNKNOWN;
        }

        return CC_ERR_UNKNOWN;
    } // picture2()

    function picture_multipart(
        $pics, // IN array of pictures binary data
        $questions, // IN array of questions
        &$pict_to, // IN/OUT timeout specifier to be used, on return - really used specifier, see CC_PTO_XXX constants, CC_PTO_DEFAULT in case of unrecognizable
        &$pict_type, // IN/OUT type specifier to be used, on return - really used specifier, see CC_PT_XXX constants, CC_PT_UNSPECIFIED in case of unrecognizable
        &$text, // OUT text
        &$major_id, // OUT major part of the picture ID
        &$minor_id // OUT minor part of the picture ID
    ) {
        if (!isset($pics)) {
            // $pics - should have a pic
            return CC_ERR_BAD_PARAMS;
        }

        if (!is_array($pics)) {
            // $pics should be an array
            $pics = array($pics);
        }

        if (isset($questions) && !is_array($questions)) {
            $questions = array($questions);
        }

        $pack = '';

        switch($pict_type) {
            case CC_PT_ASIRRA:
                // ASIRRA must have CC_PT_ASIRRA_PICS_NUM pictures
                if (count($pics) !== CC_PT_ASIRRA_PICS_NUM) {
                    return CC_ERR_BAD_PARAMS;
                }

                // combine all images into one bunch
                $pack = '';
                
                foreach($pics as &$pic) {
                    $pack .= pack('V', strlen($pic));
                    $pack .= $pic;
                }
            break;

            case CC_PT_MULTIPART:
                // MULTIPART image should have reasonable number of pictures
                if (count($pics) > CC_PT_MULTIPART_PICS_NUM) {
                    return CC_ERR_BAD_PARAMS;
                }

                if (is_array($questions) && (count($questions) > CC_PT_MULTIPART_PICS_NUM)) {
                    return CC_ERR_BAD_PARAMS;
                }

                // combine all images into one bunch
                $size = count($pics) * 4;
                
                foreach($pics as &$pic) {
                    $size += strlen($pic);
                }

                $pack = '';
                $pack .= pack('V', CC_I_MAGIC); // i_magic
                $pack .= pack('V', count($pics)); // N
                $pack .= pack('V', $size); // size
                
                foreach($pics as &$pic) {
                    $pack .= pack('V', strlen($pic));
                    $pack .= $pic;
                }

                if (is_array($questions)) {
                    // combine all questions into one bunch
                    $size = count($questions) * 4;
                    
                    foreach($questions as &$question) {
                        $size += strlen($question);
                    }

                    $pack .= pack('V', CC_Q_MAGIC); // q_magic
                    $pack .= pack('V', count($questions)); // N
                    $pack .= pack('V', $size); // size
                    
                    foreach($questions as &$question) {
                        $pack .= pack('V', strlen($question));
                        $pack .= $question;
                    }
                } // if (is_array($texts))
            break;

            default:
                // we serve only ASIRRA multipart pictures so far
                return CC_ERR_BAD_PARAMS;
            break;
        } // switch(pict_type)


        return $this->picture2($pack, $pict_to, $pict_type, $text, $major_id, $minor_id);
    } // picture_asirra()

    function picture_bad2($major_id, $minor_id) {
        $pack = new cc_packet();

        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_PICTUREFL);

        $desc = new cc_pict_descr();
        $desc->setTimeout(CC_PTO_DEFAULT);
        $desc->setType(CC_PT_UNSPECIFIED);
        $desc->setMajorID($major_id);
        $desc->setMinorID($minor_id);
        $desc->calcSize();

        $pack->setData($desc->pack());
        $pack->calcSize();

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        return CC_ERR_OK;
    } // picture_bad2()

    function balance(&$balance) {
        if ($this->status !== sCCC_PICTURE) {
            return CC_ERR_STATUS;
        }

        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_BALANCE);
        $pack->setSize(0);

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        switch($pack->getCmd()) {
            case CC_CMD_BALANCE:
                $balance = $pack->getData();
                return CC_ERR_OK;

            default:
                // unknown error
                return CC_ERR_UNKNOWN;
        }
    } // balance()

    /**
     * $sum should be int
     * $to should be string
     */
    function balance_transfer($sum, $to) {
        if ($this->status !== sCCC_PICTURE) {
            return CC_ERR_STATUS;
        }

        if (!is_int($sum)) {
            return CC_ERR_BAD_PARAMS;
        }

        if (!is_string($to)) {
            return CC_ERR_BAD_PARAMS;
        }

        if ($sum <= 0) {
            return CC_ERR_BAD_PARAMS;
        }

        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_BALANCE_TRANSFER);

        $desc = new cc_balance_transfer_descr();
        $desc->setTo($to);
        $desc->setSum($sum);
        $desc->calcSize();
        $pack->setData($desc->pack());
        $pack->calcSize();

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        switch($pack->getCmd()) {
            case CC_CMD_OK:
                return CC_ERR_OK;

            default:
                // unknown error
                return CC_ERR_GENERAL;
        }
    } // balance_tansfer()

    function system_load(&$system_load) {
        if ($this->status !== sCCC_PICTURE) {
            return CC_ERR_STATUS;
        }

        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_SYSTEM_LOAD);
        $pack->setSize(0);

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->getSize() !== 1) {
            return CC_ERR_UNKNOWN;
        }

        switch($pack->getCmd()) {
            case CC_CMD_SYSTEM_LOAD:
                $arr = unpack('Csysload', $pack->getData());
                $system_load = $arr['sysload'];
                return CC_ERR_OK;

            default:
                // unknown error
                return CC_ERR_UNKNOWN;
        }
    } // system_load()

    function close() {
        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_BYE);
        $pack->setSize(0);

        if ($pack->packTo($this->s) === false) {
            // return CC_ERR_NET_ERROR;
        }

        fclose($this->s);
        $this->status = sCCC_INIT;

        return CC_ERR_NET_ERROR;
    } // close()

    function closes() {
        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_OK);
        $pack->setSize(0);

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s, CC_CMD_OK) === false) {
            // return CC_ERR_NET_ERROR;
        }

        fclose($this->s);
        $this->status = sCCC_INIT;

        return CC_ERR_NET_ERROR;
    } // close()

    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////

    /**
    * deprecated functions section. still operational, but better not to be used
    */

    function picture($pict, &$text) {
        if ($this->status !== sCCC_PICTURE) {
            return CC_ERR_STATUS;
        }

        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_PICTURE);
        $pack->setSize(strlen($pict));
        $pack->setData($pict);

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        if ($pack->unpackFrom($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        switch($pack->getCmd()) {
            case CC_CMD_TEXT:
                $text = $pack->getData();
                return CC_ERR_OK;

            case CC_CMD_BALANCE:
                // balance depleted
                return CC_ERR_BALANCE;

            case CC_CMD_OVERLOAD:
                // server's busy
                return CC_ERR_OVERLOAD;

            case CC_CMD_TIMEOUT:
                // picture timed out
                return CC_ERR_TIMEOUT;

            case CC_CMD_FAILED:
                // server's error
                return CC_ERR_GENERAL;

            default:
                // unknown error
                return CC_ERR_UNKNOWN;
        }
    } // picture()

    function picture_bad() {
        $pack = new cc_packet();
        $pack->setVer(CC_PROTO_VER);
        $pack->setCmd(CC_CMD_FAILED);
        $pack->setSize(0);

        if ($pack->packTo($this->s) === false) {
            return CC_ERR_NET_ERROR;
        }

        return CC_ERR_NET_ERROR;
    } // picture_bad()
}
