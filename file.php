<?php
//i made this silly thing to try making it cleaner but it sux
class File
{
    private $h;

    public function init($file_name)
    {
        $this->h = @fopen($file_name, "r");
        if (!$this->h)
            return false;
        return $this->h;
    }
    public function set($offset)
    {
        fseek($this->h, $offset);
    }
    public function read($len)
    {
       return fread($this->h, $len);
    }
}
