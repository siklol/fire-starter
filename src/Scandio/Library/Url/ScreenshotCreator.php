<?php
namespace Scandio\Library\Url;

class ScreenshotCreator
{
    /**
     * @param $url
     * @param $screenDir
     * @param null $filename
     * @return null|string
     */
    public static function getByCutyCapt($url, $screenDir, $filename=null)
    {
        $filename = !is_null($filename) ? $filename : uniqid().'.jpg';

        $cmd  = 'xvfb-run --server-args="-screen 0, 1024x768x24"';
        $cmd .= ' cutycapt --url="'.$url.'"';
        $cmd .= ' --out="'.$screenDir.'/'.$filename.'"';

        shell_exec(escapeshellcmd($cmd));

        if (!is_file($screenDir.'/'.$filename)) {
            $filename = null;
        }

        return $filename;
    }

    /**
     * @param $url
     * @param $screenDir
     * @param null $filename
     * @return null|string
     */
    public static function getByWkhtmltopdf($url, $screenDir, $filename=null)
    {
        $filename = !is_null($filename) ? $filename : uniqid().'.pdf';

        $cmd  = 'xvfb-run --server-args="-screen 0, 1024x768x24"';
        $cmd .= ' wkhtmltopdf "'.$url.'"';
        $cmd .= ' "'.$screenDir.'/'.$filename.'"';

        shell_exec(escapeshellcmd($cmd));

        if (!is_file($screenDir.'/'.$filename)) {
            $filename = null;
        }

        return $filename;
    }
}