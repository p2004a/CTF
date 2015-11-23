<?php
class Timer
{
    function __construct ()
    {
        $this->Reset();
    }
    private $Start=null;
    private $End=null;
    private $Time=0;
    protected function GetTime()
    {
        list($microsec,$sec)=explode(" ",microtime());
        $utime = $microsec +$sec;
        return $utime*1000000;
    }
    function Reset ()
    {
        return $this->Start = $this->GetTime(true);
    }
    function Time()
    {
        return $this->Time;
    }
    function Count()
    {
        $TimeMicroseconds = $this->GetTime(true) - $this->Start;
        return  $this->Time+=$TimeMicroseconds / 1000000.0;
    }
}