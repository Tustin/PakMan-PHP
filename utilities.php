<?php
//PakMan PHP by Tustin
//Thanks to:
//Specter
//Smithy
//dat boi (o shit waddup)
define("CNT_HEADER", "7F434E54");
define("PKG_HEADER", "7F504B47");
require_once("file.php");
class Utilities
{
    private $pkgInfo = [
        "magic" => null,
        "contentID" => null,
        "size" => null,
        "dataSize" => null,
        "dataOffset" => null,
        "pkgContentsAddress",
        "contents" => [
        ],
    ];

    private static function str2hex($string)
    {
        $hex = '';
        for ($i=0; $i<strlen($string); $i++)
        {
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }
    private static function hex2str($hex)
    {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2)
        {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

    public static function parse($file_name)
    {
        $file = new File;

        $file->init($file_name);

        $magic = Utilities::str2hex($file->read(4));

        if ($magic == CNT_HEADER)
        {
            $pkgInfo["magic"] = "CNT";

            $file->set(0x40);
            $pkgInfo["contentID"] = $file->read(0x24);
        } 
        else if ($magic == PKG_HEADER)
        {
            $pkgInfo["magic"] = "PKG";
            
            $file->set(0x30);
            $pkgInfo["contentID"] = $file->read(0x24);
        } 
        else 
        {
            $pkgInfo["magic"] = "UNK";
        }


        if ($magic == CNT_HEADER || $magic == PKG_HEADER)
        {
            $file->set(0x18);
            $pkgInfo['size'] = Utilities::str2hex($file->read(8));

            $file->set(0x28);
            $pkgInfo['dataSize'] = Utilities::str2hex($file->read(8));

            $file->set(0x20);
            $pkgInfo['dataOffset'] = Utilities::str2hex($file->read(8));

        }
        if ($magic == CNT_HEADER)
        {
            $file->set(0x2B30);
            $pkgInfo["pkgContentsAddress"] = Utilities::str2hex($file->read(4));

            $file->set(hexdec($pkgInfo["pkgContentsAddress"]) + 1);

            //pretty dirty but it works
            $pkgContents = explode("00", Utilities::str2hex($file->read(200)), 19);
            foreach ($pkgContents as $pkg)
            {
                if ($pkg != '')
                    $pkgInfo['contents'][] = Utilities::hex2str($pkg);
                else break;
            }
        }
        return $pkgInfo;
    }
}