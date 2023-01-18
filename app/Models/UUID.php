<?php

namespace ShellaiDev\Models;

class UUID {

    /* Convert hex to UUID */
    public static function toUUID($hex) {
        $msb = substr($hex, 0, 16);
        $lsb = substr($hex, 16, 16);
        $msb = substr($msb, 14, 2) . substr($msb, 12, 2) . substr($msb, 10, 2) . substr($msb, 8, 2) . substr($msb, 6, 2) . substr($msb, 4, 2) . substr($msb, 2, 2) . substr($msb, 0, 2);
        $lsb = substr($lsb, 14, 2) . substr($lsb, 12, 2) . substr($lsb, 10, 2) . substr($lsb, 8, 2) . substr($lsb, 6, 2) . substr($lsb, 4, 2) . substr($lsb, 2, 2) . substr($lsb, 0, 2);
        $hex = $msb . $lsb;
        $uuid = substr($hex, 0, 8) . '-' . substr($hex, 8, 4) . '-' . substr($hex, 12, 4) . '-' . substr($hex, 16, 4) . '-' . substr($hex, 20, 12);
    
        return $uuid;
    }

    /* Convert from UUID to Bindata (Mongodb) */
    public static function fromUUID($uuid){
        $hex = str_replace("-", "", $uuid);

        $msb = substr($hex, 0, 16);
        $lsb = substr($hex, 16, 16);
        $msb = substr($msb, 14, 2) . substr($msb, 12, 2) . substr($msb, 10, 2) . substr($msb, 8, 2) . substr($msb, 6, 2) . substr($msb, 4, 2) . substr($msb, 2, 2) . substr($msb, 0, 2);
        $lsb = substr($lsb, 14, 2) . substr($lsb, 12, 2) . substr($lsb, 10, 2) . substr($lsb, 8, 2) . substr($lsb, 6, 2) . substr($lsb, 4, 2) . substr($lsb, 2, 2) . substr($lsb, 0, 2);
        $hex = $msb . $lsb;

        $uuid = hex2bin($hex);
        $uuid = new \MongoDB\BSON\Binary($uuid, 3);
        
        return $uuid;
    }

    /** Generate Offline UUID */
    public static function offlineUUID($name){
        return self::uuidFromString("OfflinePlayer:" . $name);
    }

    /** UUID from string */
    private static function uuidFromString($string){
        $val = md5($string, true);
        $byte = array_values(unpack('C16', $val));
    
        $tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
        $tMi = ($byte[4] << 8) | $byte[5];
        $tHi = ($byte[6] << 8) | $byte[7];
        $csLo = $byte[9];
        $csHi = $byte[8] & 0x3f | (1 << 7);
    
        if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
            $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
            $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
            $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
        }
    
        $tHi &= 0x0fff;
        $tHi |= (3 << 12);
    
        $uuid = sprintf(
            '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $tLo, $tMi, $tHi, $csHi, $csLo,
            $byte[10], $byte[11], $byte[12], $byte[13], $byte[14], $byte[15]
        );
        return $uuid;
    }
}

?>