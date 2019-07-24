<?php
/**
 * Created by PhpStorm.
 * User: abi
 * Date: 24.07.2019
 * Time: 10:29
 */

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;


class ConvertVoucherTest extends TestCase
{
    function setUp(): void
    {
        chdir(sys_get_temp_dir());
    }

    function testNoArgument()
    {
        $process = new Process(['php', __DIR__.'/../convertvouchers.php']);
        $process->run();
        $this->assertEquals("Usage: php convertvouchers.php [input file]\n", $process->getOutput());
    }

    function testInvalidFile()
    {
        $process = new Process(['php', __DIR__.'/../convertvouchers.php', '/dev/null/invalid']);
        $process->run();
        $this->assertEquals("File not found: /dev/null/invalid\n", $process->getOutput());
    }

    function testConvert()
    {
        $argv[1] = realpath(__DIR__.'/sample_data/pfsense.csv');
        ob_start();
        require __DIR__.'/../convertvouchers.php';

        $this->assertFileExists('vouchers.csv');
        $this->assertFileEquals(__DIR__.'/sample_data/converted.csv','vouchers.csv');
        $this->assertEquals("Converted file saved as vouchers.csv\n", ob_get_clean());
    }
    function tearDown(): void
    {
        if(file_exists('vouchers.csv'))
            unlink('vouchers.csv');
    }
}