<?php
/**
 * Created by PhpStorm.
 * User: isac
 * Date: 06/07/2017
 * Time: 6:00 PM
 */

namespace Joomla\Testing\Coordinator;

use Joomla\Testing\Util\Command;
use React\Promise\Deferred;
use React\Promise\Promise;

class Task
{
	private $codeceptionTask;
	private $server;
	private $client;

	/**
	 * Task constructor.
	 * @param $codeceptionTask
	 * @param $server
	 * @param $client
	 */
	public function __construct($codeceptionTask, $server)
	{
		$this->codeceptionTask = $codeceptionTask;
		$this->server = $server;
	}


	public function asyncRun($client)
	{
		$deferred = new Deferred();

		$deferred->promise()
			->then(
				function($result){
					echo "success";
					echo $result;
				},
				function($result){
					echo "fail";
					echo $result;
				}
				);

		$deferred->resolve($this->run($client));
	}

	private function run($client)
	{
		$command = "docker exec $client /bin/sh -c \"cd /usr/src/tests/tests;vendor/bin/robo run:container-tests 
					--single --test $this->codeceptionTask --server $this->server\"";

		return Command::execute($command);
	}

	private function success()
	{
		echo "success";
	}

	private function fail()
	{
		echo "fail";
	}

}