<?php


namespace Tests\onOffice\SDK;

use Symfony\Component\Process\Process;

class SDKIntegrationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * tests if faketime package is available
     */
    public function test_faketime_available()
    {
        $process = new Process(['which', 'faketime']);
        $process->run();
        $this->assertSame(0, $process->getExitCode());
    }

    /**
     * @depends test_faketime_available
     * Tests if ncat from nmap package is installed
     */
    public function test_ncat_available()
    {
        $process = new Process(['which', 'ncat']);
        $process->run();
        $this->assertSame(0, $process->getExitCode());
    }


    /**
     * @depends test_ncat_available
     */
    public function test_request_structure_correct()
    {
        $ncat = new Process(['ncat', '-n', '--ssl', '-l', '1234', '-i', '1', '-4']);
        $ncat->setTimeout(5);
        $ncat->setIdleTimeout(5);

        $ncat->start();

        $script = <<<'EOS'
        require_once 'vendor/autoload.php';
        $sdk = new \onOffice\SDK\onOfficeSDK();
        $sdk->setApiVersion('latest');
        $sdk->setApiServer('https://localhost:1234/api/');
        $sdk->setApiCurlOptions([CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]);
        $sdk->call(\onOffice\SDK\onOfficeSDK::ACTION_ID_READ, '', null, 'calendar', [
            'allusers' => false,
            'dateend' => '25-03-2022 02:17:53',
            'datestart' => '25-03-2022 02:17:53',
            'showcancelled' => true
        ]);

        // sleep at most one second to send the request at timestamp 1646228220        
        $current = microtime(true);
        $expected = (new \DateTime('2022-03-02 13:37:00 UTC'))->format('U');

        $sleepTimeMicroSeconds = $expected - $current;

        if ($sleepTimeMicroSeconds > 0) {
            usleep(intval($sleepTimeMicroSeconds * 1000000));
        }        
        
        $sdk->sendRequests('testtoken', 'testsecret');
EOS;

        sleep(2);
        $php = new Process(['faketime', '2022-03-02 13:36:59 UTC', 'php', '-r', $script], dirname(__DIR__));
        $php->setTimeout(2);
        $php->setIdleTimeout(2);
        $php->start();

        $this->assertTrue($ncat->isStarted());

        if ($php->isTerminated())
        {
            $this->fail('PHP terminated');
            return;
        }

        while ($ncat->isRunning() || $php->isRunning()) {
            try {
                $php->checkTimeout();
                $ncat->checkTimeout();
            } catch (\Symfony\Component\Process\Exception\ProcessTimedOutException $e) {
                $this->fail('Process took too long. //// ' . $php->getErrorOutput(). ' //// '. $ncat->getErrorOutput());
                break;
            }

            if ($ncat->getOutput() !== '') {
                $ncat->stop(0, 2);
                $php->stop(0, 2);
            }
        }

        $this->assertTrue($ncat->isTerminated());
        $this->assertTrue($php->isTerminated());

        $this->assertSame('', $ncat->getErrorOutput());

        $output = $ncat->getOutput();
        $expectedOutput =
            'POST /api/latest/api.php HTTP/1.1'."\r\n"
            .'Host: localhost:1234'."\r\n"
            .'Accept: */*'."\r\n"
            .'Accept-Encoding: deflate, gzip'."\r\n"
            .'Content-Length: 382'."\r\n"
            .'Content-Type: application/x-www-form-urlencoded'."\r\n"
            ."\r\n"
            .'{"token":"testtoken","request":{"actions":[{"actionid":"urn:onoffice-de-ns:smart:2.5:smartml:action:read","identifier":null,"parameters":{"allusers":false,"dateend":"25-03-2022 02:17:53","datestart":"25-03-2022 02:17:53","showcancelled":true},"resourceid":"","resourcetype":"calendar","timestamp":1646228220,"hmac_version":2,"hmac":"w6ifKMmAdJoKhu0vl2twvfP+ltyOTQ7LqLpvsZkOnlg="}]}}';
        $this->assertSame($expectedOutput, $output);
    }
}