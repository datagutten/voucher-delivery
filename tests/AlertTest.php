<?php
/**
 * Created by PhpStorm.
 * User: abi
 * Date: 23.07.2019
 * Time: 12:01
 */

class AlertTest extends \PHPUnit\Framework\TestCase
{
    public $voucher_file;
    function setUp(): void
    {
        $this->voucher_file = sprintf('%s/../vouchers.csv', __DIR__);
        if(!file_exists($this->voucher_file))
            copy(sprintf('%s/sample_data/test.csv', __DIR__), $this->voucher_file);
        /*else
            throw new Exception('voucher file exists');*/

        $config = __DIR__ . '/../config_alert.php';
        if(!file_exists($config))
            copy(__DIR__.'/sample_data/config_alert_test.php', $config);
    }

    function testAlert()
    {
        ob_start();
        $argv[1] = 'check';
        require __DIR__.'/../alert.php';
        $output = ob_get_clean();
        $this->assertStringContainsString('2 koder gjenstår', $output);
    }
    /*function testSendAlert()
    {
        ob_start();
        $argv[1]='debug';
        require __DIR__.'/../alert.php';
        $output = ob_get_clean();
        $this->assertEquals("Message has been sent\n",$output);
    }*/

    function tearDown(): void
    {
        if(file_exists($this->voucher_file))
            unlink($this->voucher_file);
    }
}